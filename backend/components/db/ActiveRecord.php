<?php

namespace backend\components\db;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\AttributeBehavior;
use yii\web\User;
use common\models\Employee;

class ActiveRecord extends \yii\db\ActiveRecord {

    /**
    * Constant for disable mode
    */
    const STATUS_ENABLE  = 0;
    const STATUS_DISABLE = 1;
    const STATUS_ALL     = false;
    
    //Gender
    const GENDER_MALE   = 1;
    const GENDER_FEMALE = 2;
    
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
    
    const PAGE_SIZE = 20;
    
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
        
        if (!empty(\Yii::$app->user->identity)) {
            $events[] = [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_employee_id',
                'updatedByAttribute' => 'lastup_employee_id',
            ];
        }

        return $events;
    }

    public function delete() {
        $this->disabled = self::STATUS_DISABLE;
        return $this->save();
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
}
