<?php

namespace common\components\db;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\AttributeBehavior;
use yii\web\User;

class CeActivieRecord extends ActiveRecord
{   
    /**
    * Constant for disable mode
    */
    const STATUS_ENABLE  = 0;
    const STATUS_DISABLE = 1;
    const STATUS_ALL     = false;
    
    //Gender
    const GENDER_MALE = 1;
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
                'createdByAttribute' => 'lastup_employee_id',
                'updatedByAttribute' => 'lastup_employee_id',
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'disabled',
                    ActiveRecord::EVENT_INIT => 'disabled',
                ],
                'value' => 0,
            ],
        ];
    }
    
    public static function find($tables = null)
    {
        $aWhere = [];
        if ($tables) {
            if (!is_array($tables)) {
                $tables = [$tables];
            }
            
            foreach ($tables as $table) {
                $aWhere[$table . '.disabled'] = self::STATUS_ENABLE;
            }
            
            return parent::find()->where($aWhere);
        }
        
        return parent::find()->where(['disabled' => self::STATUS_ENABLE]);
    }

    public function delete()
    {
        $this->disabled = self::STATUS_DISABLE;
        $this->save();
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
}