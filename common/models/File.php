<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "file".
 *
 * @property string $id
 * @property string $owner_id
 * @property string $employee_id
 * @property string $owner_object
 * @property string $name
 * @property string $encoded_name
 * @property string $path
 * @property boolean $is_image
 * @property string $file_type
 * @property string $file_size
 * @property string $lastup_datetime
 * @property string $datetime_created
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class File extends \common\components\db\ActiveRecord
{
    const TABLE_PROJECT = "project";   

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['owner_id', 'owner_object', 'name', 'encoded_name', 'path'], 'required'],
            [['owner_id', 'employee_id', 'file_size', 'lastup_datetime', 'datetime_created', 'lastup_employee_id'], 'integer'],
            [['path'], 'string'],
            [['is_image', 'disabled'], 'boolean'],
            [['owner_object', 'name', 'encoded_name', 'file_type'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'owner_id' => 'Owner ID',
            'employee_id' => 'Employee ID',
            'owner_object' => 'Owner Object',
            'name' => 'Name',
            'encoded_name' => 'Encoded Name',
            'path' => 'Path',
            'is_image' => 'Is Image',
            'file_type' => 'File Type',
            'file_size' => 'File Size',
            'lastup_datetime' => 'Lastup Datetime',
            'datetime_created' => 'Datetime Created',
            'lastup_employee_id' => 'Lastup Employee ID',
            'disabled' => 'Disabled',
        ];
    }
    
    
    /*
     * add file to table file
     */
    public static function addFiles($files, $employee_id, $pathFolder, $owner_id, $table) {
        //only create folder when user upload files
        if(count($files) == 0){
            return false;
        }
        $allow= array('image/jpeg','image/pjpeg','image/gif','image/png');
        $group  = self::getPath($pathFolder);
        $path = $pathFolder . $group . DIRECTORY_SEPARATOR;
        $employeeSpace = EmployeeSpace::find()->andWhere(['employee_id' => $employee_id])->one();
        if(!$employeeSpace){
            $employeeSpace = new EmployeeSpace();
            $employeeSpace->employee_id = $employee_id;
            $employeeSpace->space_project = $employeeSpace->space_total = 0;
        }
        //loop file and upload
        foreach($files as $key => $file){
            $name_file = $file["name"];
            $type = $file["type"];
            $size = $file["size"];
            $temp = $file["tmp_name"];
            $error = $file["error"];
            $extension = end(explode('.', $name_file));
            $file_name = md5($employee_id . uniqid() . $key).".".$extension;
            if ($error > 0) {
                $message = $error;
            }
            else {
                @move_uploaded_file($temp, $path.$file_name);
                $fileRecord = new File();
                $fileRecord->owner_id = $owner_id;
                $fileRecord->employee_id = $employee_id;
                $fileRecord->owner_object = $table;
                $fileRecord->name = $name_file;
                $fileRecord->path = $group.DIRECTORY_SEPARATOR.$file_name;
                $fileRecord->is_image = in_array($type, $allow)?1:0;
                $fileRecord->file_type = $extension;
                $fileRecord->file_size = $size;
                $fileRecord->encoded_name = $file_name;
                
                if(!$fileRecord->save(false)) {
                    throw new \Exception('Save record to table File fail');
                }
                
                //add size to module
                if($table == self::TABLE_PROJECT) {
                    $employeeSpace->space_project += $size;
                }
                
                $employeeSpace->space_total += $size;
                if(!$employeeSpace->save(false)) {
                    throw new \Exception('Save record to table File fail');
                }
            }
        }
    }
    
    /**
     * create folder if it don't exists
     */
    protected static function getPath($pathFolder){
        $year = date('Y');
        $month = date('m');
        if (!is_dir($pathFolder . $year)) {
            mkdir($pathFolder . $year, 0777);
        }
        if (!is_dir($pathFolder . DIRECTORY_SEPARATOR . $year . DIRECTORY_SEPARATOR.$month)) {
            mkdir($pathFolder . DIRECTORY_SEPARATOR. $year . DIRECTORY_SEPARATOR . $month, 0777);
        }
        return $year . DIRECTORY_SEPARATOR . $month;
    }
}
