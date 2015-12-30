<?php

namespace common\modules\authority;

use Yii;
use yii\base\Component;
use yii\db\Connection;
use yii\db\Query;
use yii\di\Instance;

class AuthorityManager extends Component
{
    public $assignments = [];
    /**
     * @var Connection|array|string the DB connection object or the application component ID of the DB connection.
     * After the DbManager object is created, if you want to change this property, you should only assign it
     * with a DB connection object.
     * Starting from version 2.0.2, this can also be a configuration array for creating the object.
     */
    public $db = 'db';
    
    public $packageTable = '{{%package}}';
    
    public $moduleTable = '{{%module}}';
    
    public $controllerTable = '{{%controller}}';
    
    public $actionTable = '{{%action}}';
    
    public $authorityAssignmentTable = '{{%authority_assigment}}';
    /**
     * @var string the name of the table storing authorization items. Defaults to "auth_item".
     */
    public $authorityTable = '{{%authority}}';
    
    public $employeeTable  = '{{%employee}}';
    /**
     * @var Cache|array|string the cache used to improve RBAC performance. This can be one of the following:
     *
     * - an application component ID (e.g. `cache`)
     * - a configuration array
     * - a [[\yii\caching\Cache]] object
     *
     * When this is not set, it means caching is not enabled.
     *
     * Note that by enabling RBAC cache, all auth items, rules and auth item parent-child relationships will
     * be cached and loaded into memory. This will improve the performance of RBAC permission check. However,
     * it does require extra memory and as a result may not be appropriate if your RBAC system contains too many
     * auth items. You should seek other RBAC implementations (e.g. RBAC based on Redis storage) in this case.
     *
     * Also note that if you modify RBAC items, rules or parent-child relationships from outside of this component,
     * you have to manually call [[invalidateCache()]] to ensure data consistency.
     *
     * @since 2.0.3
     */
    public $cache;
    /**
     * @var string the key used to store RBAC data in cache
     * @see cache
     * @since 2.0.3
     */
    public $cacheKey = 'authority';
    
    public $allowCache = true;

    /**
     * Initializes the application component.
     * This method overrides the parent implementation by establishing the database connection.
     */
    public function init()
    {
        parent::init();
        $this->db = Instance::ensure($this->db, Connection::className());
        $this->cache = Yii::$app->cache;
    }

    /**
     * @inheritdoc
     */
    public function checkAccess($employeeId, $permissionName, $params = [])
    {
        $this->assignments = $this->cache->get($this->cacheKey);
        if (!$this->assignments || !$this->allowCache) 
        {
            $this->assignments = $this->getAssignments($employeeId);
            $this->cache->set($this->cacheKey, $this->assignments);
        }
        
        Yii::trace("Checking authority: $permissionName", __METHOD__);

        if (!empty($this->assignments[$params['package_name']][$params['module_name']][$params['controller_name']][$permissionName])) 
        {
            return true;
        }
        
        return false;
    }

    public function getAssignment($employeeId, $action_permission,$params_allocation = [])
    {
        if (empty($employeeId)) 
        {
            return null;
        }

        $row = (new Query)
            ->select([$this->authorityTable . '.name AS authority_name', 
                $this->packageTable . '.column_name AS package_name',
                $this->moduleTable . '.name AS module_name', 
                $this->controllerTable . '.column_name AS controller_name', 
                $this->actionTable . '.name AS action_name'])
            ->from($this->employeeTable)
            ->join('INNER JOIN', $this->authorityTable, "{$this->employeeTable}.authority_id = {$this->authorityTable}.id")
            ->join('INNER JOIN', $this->authorityAssignmentTable, "{$this->authorityTable}.id = {$this->authorityAssignmentTable}.authority_id")
            ->join('INNER JOIN', $this->actionTable, "{$this->authorityAssignmentTable}.action_id = {$this->actionTable}.id")
            ->join('INNER JOIN', $this->controllerTable, "{$this->actionTable}.controller_id = {$this->controllerTable}.id")
            ->join('INNER JOIN', $this->moduleTable, "{$this->controllerTable}.module_id = {$this->moduleTable}.id")
            ->join('INNER JOIN', $this->packageTable, "{$this->moduleTable}.package_id = {$this->packageTable}.id")
            ->where([
                    "{$this->employeeTable}.id" => (string) $employeeId,
                    "{$this->packageTable}.column_name" => $params_allocation['package_name'],
                    "{$this->moduleTable}.name" => $params_allocation['module_name'],
                    "{$this->controllerTable}.column_name" => $params_allocation['controller_name'],
                    "{$this->actionTable}.name" => $action_permission,
              ])
            ->one($this->db);;

        if ($row === false) {
            return null;
        }

        return [
            'employee_id'    => $employeeId,
            'authority_name' => $row['authority_name'],
            'action_name'    => $row['action_name'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function getAssignments($employeeId)
    {
        if (empty($employeeId)) {
            return [];
        }

        $query = (new Query)
            ->select([$this->authorityTable . '.name AS authority_name', 
                $this->packageTable . '.column_name AS package_name',
                $this->moduleTable . '.name AS module_name', 
                $this->controllerTable . '.column_name AS controller_name', 
                $this->actionTable . '.name AS action_name'])
            ->from($this->employeeTable)
            ->join('INNER JOIN', $this->authorityTable, "{$this->employeeTable}.authority_id = {$this->authorityTable}.id")
            ->join('INNER JOIN', $this->authorityAssignmentTable, "{$this->authorityTable}.id = {$this->authorityAssignmentTable}.authority_id")
            ->join('INNER JOIN', $this->actionTable, "{$this->authorityAssignmentTable}.action_id = {$this->actionTable}.id")
            ->join('INNER JOIN', $this->controllerTable, "{$this->actionTable}.controller_id = {$this->controllerTable}.id")
            ->join('INNER JOIN', $this->moduleTable, "{$this->controllerTable}.module_id = {$this->moduleTable}.id")
            ->join('INNER JOIN', $this->packageTable, "{$this->moduleTable}.package_id = {$this->packageTable}.id")
            ->where(["{$this->employeeTable}.id" => (string) $employeeId]);
            
        $assignments = [];
        foreach ($query->all($this->db) as $row) {
            $assignments[$row['package_name']][$row['module_name']][$row['controller_name']][$row['action_name']] = [
                'employee_id'    => $employeeId,
                'authority_name' => $row['authority_name'],
                'action_name'    => $row['action_name'],
            ];
        }

        return $assignments;
    }
}
