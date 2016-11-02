<?php

namespace common\components\db\mysql;

use yii\db\Exception;
use common\components\db\ActiveRecord;

/**
 * QueryBuilder is the query builder for MySQL databases.
 *
 * @since 2.0
 */
class QueryBuilder extends \yii\db\mysql\QueryBuilder
{
    /**
     * Generates a SELECT SQL statement from a [[Query]] object.
     * @param Query $query the [[Query]] object from which the SQL statement will be generated.
     * @param array $params the parameters to be bound to the generated SQL statement. These parameters will
     * be included in the result with the additional parameters generated during the query building process.
     * @return array the generated SQL statement (the first array element) and the corresponding
     * parameters to be bound to the SQL statement (the second array element). The parameters returned
     * include those provided in `$params`.
     */
    public function build($query, $params = [])
    {
        $query = $query->prepare($this);
        $params = empty($params) ? $query->params : array_merge($params, $query->params);
        
        $where = $this->buildWhere($query->where, $params);
        $where .= ($where ? " AND " : " WHERE ") . "{$query->from[0]}.`disabled`=" . ActiveRecord::STATUS_ENABLE;
        //$query->from[0] --> first table join with others. Sql we get it has '... WHERE ... AND disabled=0'
        
        $clauses = [
            $this->buildSelect($query->select, $params, $query->distinct, $query->selectOption),
            $this->buildFrom($query->from, $params),
            $this->buildJoin($query->join, $params),
            $where,
            $this->buildGroupBy($query->groupBy),
            $this->buildHaving($query->having, $params),
        ];
            
        $sql = implode($this->separator, array_filter($clauses));
        $sql = $this->buildOrderByAndLimit($sql, $query->orderBy, $query->limit, $query->offset);

        $union = $this->buildUnion($query->union, $params);
        if ($union !== '') {
            $sql = "($sql){$this->separator}$union";
        }

//        var_dump($clauses);
//        echo implode('  ', $clauses) . '                                                                   ';
        return [$sql, $params];
    }
    
    /**
     * @param array $joins
     * @param array $params the binding parameters to be populated
     * @return string the JOIN clause built from [[Query::$join]].
     * @throws Exception if the $joins parameter is not in proper format
     */
    public function buildJoin($joins, &$params)
    {
        if (empty($joins)) {
            return '';
        }
        
        foreach ($joins as $i => $join) {
            if (!is_array($join) || !isset($join[0], $join[1])) {
                throw new Exception('A join clause must be specified as an array of join type, join table, and optionally join condition.');
            }
            // 0:join type, 1:join table, 2:on-condition (optional)
            list ($joinType, $table) = $join;
            $tables = $this->quoteTableNames((array) $table, $params);
            $table = reset($tables);
            $joins[$i] = "$joinType $table";
            if (isset($join[2])) {
                $condition = $this->buildCondition($join[2], $params);
                if ($condition !== '') {
                    $joins[$i] .= ' ON ' . $condition . " AND {$table}.`disabled`=" . ActiveRecord::STATUS_ENABLE;
                }
            }
        }
        
        return implode($this->separator, $joins);
    }
    
    /**
     * Quotes table names passed
     *
     * @param array $tables
     * @param array $params
     * @return array
     */
    private function quoteTableNames($tables, &$params)
    {
        foreach ($tables as $i => $table) {
            if ($table instanceof Query) {
                list($sql, $params) = $this->build($table, $params);
                $tables[$i] = "($sql) " . $this->db->quoteTableName($i);
            } elseif (is_string($i)) {
                if (strpos($table, '(') === false) {
                    $table = $this->db->quoteTableName($table);
                }
                $tables[$i] = "$table " . $this->db->quoteTableName($i);
            } elseif (strpos($table, '(') === false) {
                if (preg_match('/^(.*?)(?i:\s+as|)\s+([^ ]+)$/', $table, $matches)) { // with alias
                    $tables[$i] = $this->db->quoteTableName($matches[1]) . ' ' . $this->db->quoteTableName($matches[2]);
                } else {
                    $tables[$i] = $this->db->quoteTableName($table);
                }
            }
        }
        return $tables;
    }
    
    /**
     * Generates a batch INSERT SQL statement with common fields
     * For example,
     *
     * ```php
     * $sql = $queryBuilder->batchInsert('user', ['name', 'age'], [
     *     ['Tom', 30],
     *     ['Jane', 20],
     *     ['Linda', 25],
     * ]);
     * ```
     *
     * Note that the values in each row must match the corresponding column names.
     *
     * The method will properly escape the column names, and quote the values to be inserted.
     *
     * @param string $table the table that new rows will be inserted into.
     * @param array $columns the column names
     * @param array $rows the rows to be batch inserted into the table
     * @return string the batch INSERT SQL statement
     */
    public function batchInsert($table, $columns, $rows)
    {
        $unixtime = time();
        $employeeId = \Yii::$app->user->getId();
        $columns = array_merge($columns, ['company_id', 'datetime_created', 'lastup_datetime', 'created_employee_id', 'lastup_employee_id', 'disabled']);
        $schema = $this->db->getSchema();
        
        if (($tableSchema = $schema->getTableSchema($table)) !== null) {
            $columnSchemas = $tableSchema->columns;
        } else {
            $columnSchemas = [];
        }

        $values = [];
        foreach ($rows as $row) {
            $vs = [];
            foreach ($row as $i => $value) {
                if (isset($columns[$i], $columnSchemas[$columns[$i]]) && !is_array($value)) {
                    $value = $columnSchemas[$columns[$i]]->dbTypecast($value);
                }
                if (is_string($value)) {
                    $value = $schema->quoteValue($value);
                } elseif ($value === false) {
                    $value = 0;
                } elseif ($value === null) {
                    $value = 'NULL';
                }
                $vs[] = $value;
            }
            
            $vs[]=$unixtime;
            $vs[]=$unixtime;
            $vs[]=$employeeId;
            $vs[]=$employeeId;
            $vs[]=  ActiveRecord::STATUS_ENABLE;
            
            $values[] = '(' . implode(', ', $vs) . ')';
        }
        
        foreach ($columns as $i => $name) {
            $columns[$i] = $schema->quoteColumnName($name);
        }

        return 'INSERT INTO ' . $schema->quoteTableName($table)
        . ' (' . implode(', ', $columns) . ') VALUES ' . implode(', ', $values);
    }
}