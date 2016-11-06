<?php

namespace common\components\db;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\AttributeBehavior;
use yii\web\User;
use common\models\Employee;
use common\components\db\ActiveQuery;

class ActiveRecord extends \yii\db\ActiveRecord
{   
    /**
    * Constant for disable mode
    */
    const STATUS_ENABLE  = 0;
    const STATUS_DISABLE = 1;
    const STATUS_ALL     = false;
    
    //Constant for true, false, public, private.
    const VAL_TRUE  = 1;
    const VAL_FALSE = 0;
    
    //Gender
    const GENDER_MALE   = 1;
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
    
    public function behaviors()
    {
        return [
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
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_employee_id',
                'updatedByAttribute' => 'lastup_employee_id',
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'disabled',
                    ActiveRecord::EVENT_INIT => 'disabled',
                ],
                'value' => self::STATUS_ENABLE,
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'company_id',
                ],
                'value' => \Yii::$app->user->getCompanyId(),
            ],
        ];
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
    
    public function delete()
    {
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
    public static function deleteAll($condition = '', $params = [])
    {
        $command = static::getDb()->createCommand();
        $command->update(static::tableName(), ['disabled' => self::STATUS_DISABLE], $condition, $params);

        return $command->execute();
    }
    
    /**
     * @inheritdoc
     * @return ActiveQuery the newly created [[ActiveQuery]] instance.
     */
    public static function find()
    {
        return new ActiveQuery(get_called_class());
    }
    
    public function getBirthdateText()
    {
        return date('Y/m/d', $this->birthdate);
    }
    
    public function setBirthdateText($value)
    {
        $this->birthdate = strtotime($value);
    }
    
    public function getLastupDatetimeText()
    {
        return date('Y/m/d', $this->lastup_datetime);
    }
    
    public function setLastupDatetimeText($value)
    {
        $this->lastup_datetime = strtotime($value);
    }
    
    public function getDatetimeCreatedText()
    {
        return date('Y/m/d', $this->datetime_created);
    }
    
    public function setDatetimeCreatedText($value)
    {
        $this->datetime_created = strtotime($value);
    }
    
    public function fields()
    {
        return [
            'datetime_created' => function () {
                return date('d-m-y H:i', $this->datetime_created);
            },
        ];
    }
    public function getDiffBetweenDate() {
        return intval(abs($this->end_datetime - $this->start_datetime)/86400);
    }
}
