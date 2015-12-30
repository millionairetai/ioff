<?php

namespace common\components\db;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\web\User;

class CeActivieRecord extends ActiveRecord
{   
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
        ];
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