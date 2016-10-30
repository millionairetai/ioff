<?php

namespace member\controllers;

use common\models\File;
use common\models\ProjectPost;
use common\models\Project;
use common\models\Task;
use common\models\Event;

class FileController extends ApiController {
    
    /*
     * Function remove file screen view project when click button delete
     */
    public function actionRemoveFile() {
        $this->_message = \Yii::t('member', 'remove file success');
        $transaction = \Yii::$app->db->beginTransaction();
        //create object and validate data
        try {
            $object = [];
            if ($result = (new File())->removeFile(\Yii::$app->request->get('fileId'))) {
                $object = [
                    'onwer_id' => $result->owner_id,
                    'owner_object'=> $result->owner_object, 
                    'name' => $result->name,
                    'encoded_name' => $result->encoded_name,
                    'path' => $result->path,
                    'file_type' => $result->file_type,
                    'file_size' => $result->file_size,
                ];
            }
            
            $transaction->commit();
        } catch (\Exception $e) {
            $this->_error = true;
            $this->_message = \Yii::t('member', 'remove file error');
            $transaction->rollBack();
            return $this->sendResponse($this->_error, $this->_message, []);
        }

        return $this->sendResponse($this->_error, $this->_message, $object);
    }
    
    public function actionDownloadFile(){
        $fileId = \Yii::$app->request->get('fileId',0);
                                        
        if($fileId){
            
            $file = File::find()->select(['id', 'name', 'path', 'datetime_created'])->where(['id'=>$fileId,'company_id'=>\Yii::$app->user->getCompanyId()])->one();
            
            if($file){
                
                 $path = \Yii::$app->params['PathUpload'].str_replace(["\/","\\"],DIRECTORY_SEPARATOR,$file->path);
                 echo $path;
                 $name = $file->name;

                if (file_exists($path)) {
                    return \Yii::$app->response->sendFile($path,$name);
                }
            }            
        }        
                
    }
}
