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
    const TABLE_TASK = "task";
    const TABLE_PROJECT_POST = 'project_post';
    const TABLE_EVENT_POST = 'event_post';
    const TABLE_TASK_POST = 'task_post';

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
        $allow = array('image/jpeg', 'image/pjpeg', 'image/gif', 'image/png');
        $group = self::getPath($pathFolder);
        $path = $pathFolder . DIRECTORY_SEPARATOR . $group . DIRECTORY_SEPARATOR;
        $employeeSpace = EmployeeSpace::find()->andCompanyId()->andWhere(['employee_id' => $employeeId])->one();

        if (!$employeeSpace) {
            $employeeSpace = new EmployeeSpace();
            $employeeSpace->employee_id = $employeeId;
            $employeeSpace->space_project = $employeeSpace->space_calendar = $employeeSpace->space_total = 0;
        }

        $company = Company::find(['total_storage'])->where(Yii::$app->user->identity->company_id)->one();
        //loop file and upload
        $fileInsert = [];
        foreach ($files as $key => $file) {
            $fileName = $file["name"];
            $type = $file["type"];
            $size = $file["size"];
            $temp = $file["tmp_name"];
            $error = $file["error"];
            $extension = end(explode('.', $fileName));
            $fileEncodeName = md5($employeeId . uniqid() . $key) . "." . $extension;

            if ($error > 0) {
                $message = $error;
            } else {
                if (!@move_uploaded_file($temp, $path . $fileEncodeName)) {
                    throw new \Exception('Can not upload file:' . $fileEncodeName);
                }

                $fileInsert[] = [
                    'owner_id' => $owner_id,
                    'employee_id' => $employeeId,
                    'owner_object' => $table,
                    'name' => $fileName,
                    'path' => $group . DIRECTORY_SEPARATOR . $fileEncodeName,
                    'is_image' => in_array($type, $allow) ? 1 : 0,
                    'file_type' => $extension,
                    'file_size' => $size,
                    'encoded_name' => $fileEncodeName,
                ];

                //add size to module
                if ($table == self::TABLE_PROJECT || $table == self::TABLE_PROJECT_POST) {
                    $employeeSpace->space_project += $size;
                }

                if ($table == self::TABLE_EVENT || $table == self::TABLE_EVENT_POST) {
                    $employeeSpace->space_calendar += $size;
                }

                $employeeSpace->space_total += $size;
                $company->total_storage += $size;
            }
        }

        if (!\Yii::$app->db->createCommand()->batchInsert(File::tableName(), array_keys($fileInsert[0]), $fileInsert)->execute()) {
            throw new \Exception('Save record to table file fail');
        }

        if (!$employeeSpace->save(false)) {
            throw new \Exception('Save record to table Employee Space fail');
        }

        if (!$company->save(false)) {
            throw new \Exception('Save record to table company fail');
        }

        return $fileInsert;
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
     * Delete file
     * 
     * @param int $fileId
     * @return boolean
     */
    public function removeFile($fileId) {
        if (empty($fileId)) {
            throw new \Exception('Can not get file id');
        }

        $file = File::findOne($fileId);
        if (empty($file)) {
            throw new \Exception('Can not get file');
        }

        if (!$file->delete()) {
            throw new \Exception('Can not delete file');
        }

        file_exists($unlink = \Yii::$app->params['PathUpload'] . DIRECTORY_SEPARATOR . $file->path) ? unlink($unlink) : false;
        //subtract total_storage and space_project
        $company = Company::find(['total_storage'])->where(Yii::$app->user->identity->company_id)->one();
        $company->total_storage = $company->total_storage - $file->file_size;
        $company->total_storage = $company->total_storage >= 0 ? $company->total_storage : 0;
        if (!$company->save(false)) {
            throw new \Exception('Save record to table company fail');
        }

        $this->_updateStorageAndLogHistory($file);

        return $file;
    }

    /**
     * Get info file name by id
     * 
     * @param array $ids
     * @param string $table
     * @return boolean|array
     */
    public static function getFiles($ids = array(), $table = null) {
        if (!empty($ids)) {
            return File::findAll([
                        'owner_id' => $ids,
                        'owner_object' => $table,
                        'company_id' => \Yii::$app->user->getCompanyId()
            ]);
        }

        return [];
    }

    /**
     * Update storage and log history for project, project post, task
     *      task_post, event, event_post
     * 
     * @return boolean|array
     */
    protected function _updateStorageAndLogHistory($file) {
        //subtract total_storage and space_project
        $employeeSpace = EmployeeSpace::find()->andCompanyId()->andWhere(['employee_id' => $file->employee_id])->one();
        //Update post to each respective table.
        switch ($file->owner_object) {
            case 'project':
            case 'project_post':
                //subtract space_project in employe_space.
                $employeeSpace->space_project = $employeeSpace->space_project - $file->file_size;
                $employeeSpace->space_project = $employeeSpace->space_project >= 0 ? $employeeSpace->space_project : 0;
                $employeeSpace->space_total = $employeeSpace->space_total - $file->file_size;
                $employeeSpace->space_total = $employeeSpace->space_total >= 0 ? $employeeSpace->space_project : 0;

                //write logs project post
                $projectPost = new ProjectPost();
                $projectPost->project_id = $file->owner_id;
                $projectPost->employee_id = \Yii::$app->user->getId();
                $projectPost->parent_id = 0;
                $projectPost->content = '<ul><li>' . \Yii::t('member', 'delete file') . '<div class="padding-left-20">' . $file->name . '</div></li></ul>';
                $projectPost->content_parse = '<ul><li>' . \Yii::t('member', 'delete file') . '<div class="padding-left-20">' . $file->name . '</div></li></ul>';
                $projectPost->parent_employee_id = 0;
                if (!$projectPost->save(false)) {
                    throw new \Exception('Save record to table project post fail');
                }
                break;

            case 'task':
            case 'task_post':
                break;

            case 'event':
            case 'event_post':              
                //subtract space_calendar in employe_space.
                $employeeSpace->space_calendar = $employeeSpace->space_calendar - $file->file_size;
                $employeeSpace->space_calendar = $employeeSpace->space_calendar >= 0 ? $employeeSpace->space_calendar : 0;
                $employeeSpace->space_total = $employeeSpace->space_total - $file->file_size;
                $employeeSpace->space_total = $employeeSpace->space_total >= 0 ? $employeeSpace->space_project : 0;
                
                //write logs event post
                $eventPost = new EventPost();
                $eventPost->event_id = $file->owner_id;
                $eventPost->employee_id = \Yii::$app->user->getId();
                $eventPost->parent_id = 0;
                $eventPost->is_log_history = self::VAL_TRUE;
                $eventPost->content = '<ul><li>' . \Yii::t('member', 'delete file') . '<div class="padding-left-20">' . $file->name . '</div></li></ul>';
                $eventPost->content_parse = '<ul><li>' . \Yii::t('member', 'delete file') . '<div class="padding-left-20">' . $file->name . '</div></li></ul>';
                $eventPost->parent_employee_id = 0;
                if (!$eventPost->save(false)) {
                    throw new \Exception('Save record to table event post fail');
                }
                break;

            default:
                break;
        }

        if (!$employeeSpace->save(false)) {
            throw new \Exception('Save record to table employee space fail');
        }

        return true;
    }

    /**
     * Get list file by owner id and table name
     * 
     * @param string $ownerId
     * @param string $tableName
     * @param string $object
     * @return array|null
     */
    public static function getFileByOwnerIdAndTable($ownerId = null, $tableName = null, $object = false) {
        if (($ownerId == null) || ($tableName == null)) {
            return null;
        }

        $innerJoinTable = $tableName . '_post';
        $query = (new \yii\db\Query())
                        ->select(['file.id', 'file.name', 'file.path', 'file.datetime_created'])
                        ->from(File::tableName())
                        ->where([
                            'file.company_id' => \Yii::$app->user->getCompanyId(),
                            'file.owner_object' => $tableName,
                            'file.owner_id' => $ownerId,
                        ])->union((new \yii\db\Query())
                        ->select(['file.id', 'file.name', 'file.path', 'file.datetime_created'])
                        ->from(File::tableName())
                        ->innerJoin($innerJoinTable, "{$innerJoinTable}.id = file.owner_id AND {$innerJoinTable}.{$tableName}_id={$ownerId}")
                        ->where([
                            'file.company_id' => \Yii::$app->user->getCompanyId(),
                            'file.owner_object' => $tableName . '_post',
                        ]), false);

        $sql = $query->createCommand()->getRawSql();
        $sql .= ' ORDER BY datetime_created DESC';
        $files = File::findBySql($sql)->all();

        if (empty($files)) {
            return null;
        }

        $fileList = [];
        if (!$object) {
            foreach ($files as $file) {
                $fileList[] = [
                    'id' => $file->id,
                    'name' => $file->name,
                    'path' => \Yii::$app->params['PathUpload'] . DIRECTORY_SEPARATOR . $file->path,
                    'datetime_created' => date('Y-m-d', $file->datetime_created),
                ];
            }
        } else {
            return $files;
        }
        return $fileList;
    }
    
    public static function getFileByFileIdAndOwnerIdAndTable($fileId = false,$ownerId = false, $tableName = false) {
        
        $innerJoinTable = $tableName . '_post';
        $query = (new \yii\db\Query())
                        ->select(['file.id', 'file.name', 'file.path', 'file.datetime_created'])
                        ->from(File::tableName())
                        ->where([
                            'file.id' => $fileId,
                            'file.company_id' => \Yii::$app->user->getCompanyId(),
                            'file.owner_object' => $tableName,
                            'file.owner_id' => $ownerId,
                        ])->union((new \yii\db\Query())
                        ->select(['file.id', 'file.name', 'file.path', 'file.datetime_created'])
                        ->from(File::tableName())
                        ->innerJoin($innerJoinTable, "{$innerJoinTable}.id = file.owner_id AND {$innerJoinTable}.{$tableName}_id={$ownerId}")
                        ->where([
                            'file.id' => $fileId,
                            'file.company_id' => \Yii::$app->user->getCompanyId(),
                            'file.owner_object' => $tableName . '_post',
                        ]), false);

        $sql = $query->createCommand()->getRawSql();
        $file = File::findBySql($sql)->one();
        
        return $file;
    }
        
}
