<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "file".
 *
 * @property string $id
 * @property string $company_id
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
class File extends \common\components\db\ActiveRecord {

    const TABLE_PROJECT = "project";
    const TABLE_EVENT = "event";

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'file';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['owner_id', 'owner_object', 'name', 'encoded_name', 'path'], 'required'],
            [['company_id', 'owner_id', 'employee_id', 'file_size', 'lastup_datetime', 'datetime_created', 'lastup_employee_id'], 'integer'],
            [['path'], 'string'],
            [['is_image', 'disabled'], 'boolean'],
            [['owner_object', 'name', 'encoded_name', 'file_type'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'owner_id' => 'Owner ID',
            'company_id' => 'Owner ID',
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

    /**
     * Upload file and update to db for file upload
     * 
     * @param resource $files path of folder
     * @param string $pathFolder path of folder
     * @param integer $owner_id path of folder
     * @param string $table path of folder
     * @return array
     */
    public static function addFiles($files, $pathFolder, $owner_id, $table) {
        //only create folder when user upload files
        if (count($files) == 0) {
            return false;
        }

        $employeeId = \Yii::$app->user->getId();
        $allow = array('image/jpeg','image/pjpeg','image/gif','image/png');
        $group = self::getPath($pathFolder);
        $path = $pathFolder . DIRECTORY_SEPARATOR . $group . DIRECTORY_SEPARATOR;
        $employeeSpace = EmployeeSpace::find()->andCompanyId()->andWhere(['employee_id' => $employeeId])->one();

        if (!$employeeSpace) {
            $employeeSpace = new EmployeeSpace();
            $employeeSpace->employee_id = $employeeId;
            $employeeSpace->space_project = $employeeSpace->space_total = 0;
        }
        
        //loop file and upload
        $listFiles = [];
        foreach ($files as $key => $file) {
            $fileName = $file["name"];
            $type = $file["type"];
            $size = $file["size"];
            $temp = $file["tmp_name"];
            $error = $file["error"];
            $extension = end(explode('.', $fileName));
            $fileEncodeName = md5($employeeId . uniqid() . $key).".".$extension;
            
            if ($error > 0) {
                $message = $error;
            } else {
                if (!@move_uploaded_file($temp, $path . $fileEncodeName)) {
                    throw new \Exception('Can not upload file:' . $fileEncodeName);
                }
                
                $file = new File();
                $file->owner_id = $owner_id;
                $file->employee_id = $employeeId;
                $file->owner_object = $table;
                $file->name = $fileName;
                $file->path = $group . DIRECTORY_SEPARATOR . $fileEncodeName;
                $file->is_image = in_array($type, $allow) ? 1 : 0;
                $file->file_type = $extension;
                $file->file_size = $size;
                $file->encoded_name = $fileEncodeName;

                if (!$file->save(false)) {
                    throw new \Exception('Save record to table File fail');
                }

                $listFiles[] = $file;
                //add size to module
                if ($table == self::TABLE_PROJECT) {
                    $employeeSpace->space_project += $size;
                }   
                
                if ($table == self::TABLE_EVENT) {
                    $employeeSpace->space_calendar += $size;
                }

                $employeeSpace->space_total += $size;
            }
        }
        
        if (!$employeeSpace->save(false)) {
            throw new \Exception('Save record to table File fail');
        }
        
        return $listFiles;
    } 

    /**
     * Create folder if it don't exists
     * 
     * @param string $pathFolder path of folder
     * @return string
     */
    protected static function getPath($pathFolder) {
        $year = date('Y');
        $month = date('m');
        $companyId = \Yii::$app->user->getCompanyId();

        if (!is_dir($pathFolder . DIRECTORY_SEPARATOR . $companyId)) {
            mkdir($pathFolder . DIRECTORY_SEPARATOR . $companyId, 0777);
        }

        if (!is_dir($pathFolder . DIRECTORY_SEPARATOR . $companyId . DIRECTORY_SEPARATOR . $year)) {
            mkdir($pathFolder . DIRECTORY_SEPARATOR . $companyId . DIRECTORY_SEPARATOR . $year, 0777);
        }

        if (!is_dir($pathFolder . DIRECTORY_SEPARATOR . $companyId . DIRECTORY_SEPARATOR . $year . DIRECTORY_SEPARATOR . $month)) {
            mkdir($pathFolder . DIRECTORY_SEPARATOR . $companyId . DIRECTORY_SEPARATOR . $year . DIRECTORY_SEPARATOR . $month, 0777);
        }

        return $companyId . DIRECTORY_SEPARATOR . $year . DIRECTORY_SEPARATOR . $month;
    }

    /**
     * Action delete file and remove file hard
     * 
     * @param int $fileId
     * @return boolean
     */
    public  function removeFile($fileId) {   
        if (isset($fileId)) {
            $data = File::findOne($fileId);
            if (!empty($data)) {
                if ($data->delete()) {
                    file_exists($unlink = \Yii::$app->params['PathUpload'].DIRECTORY_SEPARATOR.$data->path) ? unlink($unlink) : false;
                    //write logs project post
                    $projectPost = new ProjectPost();
                    $projectPost->project_id    = $data->owner_id;
                    $projectPost->employee_id   = \Yii::$app->user->getId();
                    $projectPost->parent_id     = 0;
                    $projectPost->content       =  '<ul><li>'.\Yii::t('member', 'delete file') . '<div class="padding-left-20">'. $data->name.'</div></li></ul>';
                    $projectPost->content_parse =  '<ul><li>'.\Yii::t('member', 'delete file') . '<div class="padding-left-20">'. $data->name.'</div></li></ul>';
                    $projectPost->parent_employee_id = 0;
                    $projectPost->save(false);
                    return false;
                }
            }
        }
    	return true;
    }
    
    /**
     * get info file name by id
     * @param array $ids
     * @param unknown $table
     * @return boolean|array
     */
    public static function getFiles($ids = array(), $table = null){
    	if(!empty($ids)){
    		return File::findAll([
                'owner_id'      => $ids, 
                'owner_object'  => $table, 
                'company_id'    => \Yii::$app->user->getCompanyId()
            ]);
    	}
        
    	return false;
    }
}
