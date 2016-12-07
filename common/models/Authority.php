<?php

namespace common\models;

use Yii;
use common\models\Employee;

/**
 * This is the model class for table "authority".
 *
 * @property string $id
 * @property string $company_id
 * @property string $name
 * @property string $description
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $created_employee_id
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class Authority extends \common\components\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'authority';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['company_id', 'datetime_created', 'lastup_datetime', 'created_employee_id', 'lastup_employee_id'], 'integer'],
            [['name'], 'required'],
            [['description'], 'string'],
            [['disabled'], 'boolean'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'company_id' => 'Company ID',
            'name' => 'Name',
            'description' => 'Description',
            'datetime_created' => 'Datetime Created',
            'lastup_datetime' => 'Lastup Datetime',
            'created_employee_id' => 'Created Employee ID',
            'lastup_employee_id' => 'Lastup Employee ID',
            'disabled' => 'Disabled',
        ];
    }

    /**
     * Get list of authority
     */
    public static function getAll($request, $companyId) {
        $limit   = (isset($request['limit'])) ? $request['limit'] : self::PER_PAGE;
        $page    = (isset($request['page']))  ? $request['page']  : 1;
        $offset  = ($page - 1) * $limit;
        $orderBy = self::tableName() . '.lastup_datetime';
        
        if (isset($request['orderBy']) && $request['orderBy']) {
            $orderBy = self::tableName() . '.' . $request['orderBy'];
            
            if ($request['orderBy'] == 'employeeName') {
                $orderBy = Employee::tableName() . '.firstname';
            }
        }
        
        $orderType   = (isset($request['orderType']) && $request['orderType']) ? $request['orderType'] : 'DESC';
        $authorities = self::find()
                            ->select(self::tableName() . '.name,' . self::tableName() . '.lastup_datetime,' . self::tableName() . '.id,' .
                                Employee::tableName() . '.firstname, ' . Employee::tableName() . '.lastname')
                            ->leftJoin(Employee::tableName(), self::tableName() . '.lastup_employee_id=' . Employee::tableName() . '.id')
                            ->where([self::tableName() . '.company_id' => $companyId]);

        if (isset($request['authorityName']) && $request['authorityName']) {
            $authorities = $authorities->andWhere(['like', self::tableName() . '.name', $request['authorityName']]);
        }

        return $authorities->offset($offset)->limit($limit)->orderBy($orderBy . ' ' . $orderType)->asArray()->all();
    }
    
    /**
     * Get employee auth by employee id.
     * 
     * @param interger $employeeId
     * @return array|null
     */
    public static function getAuthByEmployeeId($employeeId) {
        return Employee::find()
            ->select(['action.name AS action_name', 'url', 'controller.name AS controller_name'])
            ->leftJoin('authority', 'authority.id = employee.authority_id')
            ->leftJoin('authority_assigment', 'authority.id = authority_assigment.authority_id')
            ->leftJoin('action', 'authority_assigment.action_id = action.id')
            ->leftJoin('controller', 'action.controller_id = controller.id')
            ->where(["employee.id" => $employeeId])
            ->asArray()
            ->all();
    }

}
