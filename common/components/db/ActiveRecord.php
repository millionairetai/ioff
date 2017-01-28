<?php

namespace common\components\db;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\AttributeBehavior;
use yii\web\User;
use common\models\Employee;
use common\components\db\ActiveQuery;

class ActiveRecord extends \yii\db\ActiveRecord {

    /**
     * Constant for disable mode
     */
    const STATUS_ENABLE = 0;
    const STATUS_DISABLE = 1;
    const STATUS_ALL = false;
    //Constant for true, false, public, private.
    const VAL_TRUE = 1;
    const VAL_FALSE = 0;
    //Gender
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;
    //pagination
    const PER_PAGE = 20;

    protected $_genders = array(
        self::GENDER_MALE,
        self::GENDER_FEMALE
    );

    //Week
    const DAY_OF_WEEK_MON = 1;
    const DAY_OF_WEEK_TUE = 2;
    const DAY_OF_WEEK_WED = 3;
    const DAY_OF_WEEK_THU = 4;
    const DAY_OF_WEEK_FRI = 5;
    const DAY_OF_WEEK_SAT = 6;
    const DAY_OF_WEEK_SUN = 7;

    protected $_day_of_week_arr = array(
        self::DAY_OF_WEEK_MON,
        self::DAY_OF_WEEK_TUE,
        self::DAY_OF_WEEK_WED,
        self::DAY_OF_WEEK_THU,
        self::DAY_OF_WEEK_FRI,
        self::DAY_OF_WEEK_SAT,
        self::DAY_OF_WEEK_SUN
    );

    public function behaviors() {
        $events = [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['datetime_created', 'lastup_datetime'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['lastup_datetime'],
                    ActiveRecord::EVENT_BEFORE_DELETE => ['lastup_datetime'],
                    User::EVENT_BEFORE_LOGOUT => ['last_login_datetime']
                ],
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'disabled',
                    ActiveRecord::EVENT_INIT => 'disabled',
                ],
                'value' => self::STATUS_ENABLE,
            ],
        ];

        if (\Yii::$app->user->identity) {
            $events[] = [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'company_id',
                ],
                'value' => \Yii::$app->user->getCompanyId(),
            ];

            $events[] = [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_employee_id',
                'updatedByAttribute' => 'lastup_employee_id',
            ];
        }

        return $events;
    }

    /**
     * @inheritdoc
     * @return static[] an array of ActiveRecord instances, or an empty array if nothing matches.
     */
//    public static function findAll($condition)
//    {
//        if (ArrayHelper::isAssociative($condition)) {
//            $condition['company_id'] = \Yii::$app->user->getCompanyId();
//            return static::findByCondition($condition)->all();
//        }
//        
//        return static::findByCondition($condition)->all();
//    }

    /**
     * @inheritdoc
     * @return static|null ActiveRecord instance matching the condition, or `null` if nothing matches.
     */
//    public static function findOne($condition)
//    {
//        if (ArrayHelper::isAssociative($condition)) {
//            $condition['company_id'] = \Yii::$app->user->getCompanyId();
//            return static::findByCondition($condition)->one();
//        }
//        
//        return static::findByCondition($condition)->one();
//    }

    /**
     * @inheritdoc
     * @return static|null ActiveRecord instance matching the condition, or `null` if nothing matches.
     */
//    public static function findOne($where, $isAddCompanyId = true)
//    {
//        if ($isAddCompanyId) {
//            return self::find()->where($where)->andCompanyId()->one();
//        } else {
//            return self::findOne($where)->one();
//        }
//    }    

    public function delete() {
        $this->disabled = self::STATUS_DISABLE;
        return $this->save();
    }

    /**
     * Deletes rows by update disabled column = 1
     * WARNING: If you do not specify any condition, this method will delete ALL rows in the table.
     *
     * For example, to delete all customers whose status is 3:
     *
     * ```php
     * Customer::deleteAll('status = 3');
     * ```
     *
     * @param string|array $condition the conditions that will be put in the WHERE part of the DELETE SQL.
     * Please refer to [[Query::where()]] on how to specify this parameter.
     * @param array $params the parameters (name => value) to be bound to the query.
     * @return integer the number of rows deleted
     */
    public static function deleteAll($condition = '', $params = []) {
        $command = static::getDb()->createCommand();
        $command->update(static::tableName(), ['disabled' => self::STATUS_DISABLE], $condition, $params);

        return $command->execute();
    }

    /**
     * @inheritdoc
     * @return ActiveQuery the newly created [[ActiveQuery]] instance.
     */
    public static function find() {
        return new ActiveQuery(get_called_class());
    }

    public function getBirthdateText() {
        return date('Y/m/d', $this->birthdate);
    }

    public function setBirthdateText($value) {
        $this->birthdate = strtotime($value);
    }

    public function getLastupDatetimeText() {
        return date('Y/m/d', $this->lastup_datetime);
    }

    public function setLastupDatetimeText($value) {
        $this->lastup_datetime = strtotime($value);
    }

    public function getDatetimeCreatedText() {
        return date('Y/m/d', $this->datetime_created);
    }

    public function setDatetimeCreatedText($value) {
        $this->datetime_created = strtotime($value);
    }

    public function fields() {
        return [
            'datetime_created' => function () {
                return date('d-m-y H:i', $this->datetime_created);
            },
        ];
    }

    public function getDiffBetweenDate() {
        return intval(abs($this->end_datetime - $this->start_datetime) / 86400);
    }

    /**
     * Get record by id
     * 
     * @param integer $id
     * @param array $columns
     * @return ActiveQuery
     */
    public static function getById($id, $columns = [], $isReturnObj = true) {
        $return = self::find();
        if (!empty($columns)) {
            $return = $return->select($columns);
        }

        $return->andWhere(['id' => $id])->andCompanyId();

        if ($isReturnObj) {
            return $return->one();
        }

        return $return->asArray()->one();
    }
    
    /**
     * Get by name
     *
     * @param string $name
     * @return Active Record|false
     */
    public static function getByName($name) {
        return self::find()->andWhere(['name' => $name])->andCompanyId()->one();
    }

    /**
     * Get all row of table of a company
     * 
     * @param boolean $isReturnArr
     * @param array $columns
     * @return objec|array
     */
    public static function gets($columns = [], $isReturnArr = true, $dropdown = false) {
        $return = self::find();
        if (!empty($columns)) {
            $return = $return->select($columns);
        }

        if ($dropdown) {
            return $return->andCompanyId()->indexBy('id')->column();
        }

        if ($isReturnArr) {
            return $return->andCompanyId()->asArray()->all();
        }

        return $return->andCompanyId()->all();
    }

    /**
     * Get one record by params
     * 
     * @param array $params
     * @param array $columnName - list of column name in table
     * @return Active Record
     */
    public static function getOneByParams($params, $columnName = []) {
        if (!empty($columnName)) {
            return self::find()->select($columnName)->where($params)->one();
        }

        return self::find()->where($params)->one();
    }

    /**
     * Get by params
     * 
     * @param array $params
     * @param array $columnName - list of column name in table
     * @return Active Record
     */
    public static function getByParams($params, $columnName = []) {
        if (!empty($columnName)) {
            return self::find()->select($columnName)->where($params)->one();
        }

        return self::find()->where($params)->all();
    }

    /**
     * Check if record is exist by <> id and equal name.
     * 
     * @param integer $id
     * @param array $name
     * @return boolean
     */
    public static function isExist($id, $name) {
        return self::find('id')
                        ->andWhere(['<>', 'id', $id])
                        ->andWhere(['name' => $name])
                        ->andCompanyId()
                        ->exists();
    }

    /**
     * Insert array consist of 
     *          (key - column_name of table, val - value of column_name which is inserted)
     * 
     * @param array $insertArr
     * @return boolean
     */
    public function insertByArr($insertArr) {
        if (empty($insertArr)) {
            return false;
        }

        foreach ($insertArr as $key => $val) {
            $this->$key = $val;
        }

        if ($this->insert() !== false) {
            return true;
        }

        return false;
    }

    /**
     * Update array consist of 
     *          (key - column_name of table, val - value of column_name which is updated)
     * 
     * @param array $updateArr
     * @return boolean
     */ public function updateByArr($updateArr, $id) {
        if (empty($updateArr) || $id) {
            return false;
        }

        foreach ($updateArr as $key => $val) {
            $this->$key = $val;
        }

        return self::updateAll($updateArr, "id = {$id}");
    }

    /**
     * BatchInsert
     * 
     * @param array $dataInsert
     * @return boolean
     */
    public static function batchInsert($dataInsert, $columns = []) {
        if (!empty($dataInsert)) {
            if (empty($columns)) {
                $columns = array_keys($dataInsert[0]);
            }

            if (!\Yii::$app->db->createCommand()->batchInsert(self::tableName(), $columns, $dataInsert)->execute()) {
                throw new \Exception('Save record to' . self::tableName() . ' table fail');
            }
        }

        return true;
    }

}
