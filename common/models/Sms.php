<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sms".
 *
 * @property string $id
 * @property string $company_id
 * @property string $owner_id
 * @property string $employee_id
 * @property string $owner_table
 * @property string $content
 * @property boolean $is_success
 * @property string $fee
 * @property string $agency_gateway
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class Sms extends \common\components\db\ActiveRecord {

    const TABLE_PROJECT = "project";
    const TABLE_EVENT = "event";

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'sms';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['company_id', 'owner_id', 'employee_id', 'fee', 'datetime_created', 'lastup_datetime', 'lastup_employee_id'], 'integer'],
            [['owner_table', 'content'], 'required'],
            [['is_success', 'disabled'], 'boolean'],
            [['owner_table'], 'string', 'max' => 50],
            [['content', 'agency_gateway'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'company_id' => 'Company id',
            'owner_id' => 'Owner ID',
            'employee_id' => 'Employee ID',
            'owner_table' => 'Owner Table',
            'content' => 'Content',
            'is_success' => 'Is Success',
            'fee' => 'Fee',
            'agency_gateway' => 'Agency Gateway',
            'datetime_created' => 'Datetime Created',
            'lastup_datetime' => 'Lastup Datetime',
            'lastup_employee_id' => 'Lastup Employee ID',
            'disabled' => 'Disabled',
        ];
    }

    /**
     * Add sms
     * 
     * @param array $dataInsert
     * @return boolean
     */
    public static function add($dataInsert) {
        if (!empty($dataInsert)) {
            if (!\Yii::$app->db->createCommand()->batchInsert(self::tableName(), array_keys($dataInsert[0]), $dataInsert)->execute()) {
                throw new \Exception('Save record to table sms fail');
            }
        }

        return true;
    }

}
