<?php

namespace common\modules\authority\models;

use Yii;

/**
 * This is the model class for table "action".
 *
 * @property integer $id
 * @property integer $controller_id
 * @property string $name
 * @property string $description
 * @property string $url
 * @property boolean $is_display_menu
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class Action extends \common\components\db\CeActivieRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'action';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['controller_id', 'name'], 'required'],
            [['controller_id', 'datetime_created', 'lastup_datetime', 'lastup_employee_id'], 'integer'],
            [['description'], 'string'],
            [['is_display_menu', 'disabled'], 'boolean'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('authority', 'ID'),
            'controller_id' => Yii::t('authority', 'Controller ID'),
            'name' => Yii::t('authority', 'Name'),
            'description' => Yii::t('authority', 'Description'),
            'url' => Yii::t('authority', 'Url'),
            'is_display_menu' => Yii::t('authority', 'Is Display Menu'),
            'datetime_created' => Yii::t('authority', 'Datetime Created'),
            'lastup_datetime' => Yii::t('authority', 'Lastup Datetime'),
            'lastup_employee_id' => Yii::t('authority', 'Lastup Employee ID'),
            'disabled' => Yii::t('authority', 'Disabled'),
        ];
    }
}
