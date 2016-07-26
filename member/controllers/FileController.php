<?php

namespace member\controllers;

use common\models\File;
use common\models\ProjectPost;

class FileController extends ApiController {
    
    /*
     * Function remove file screen view project when click button delete
     */
    public function actionRemoveFile() {
        $this->_message = \Yii::t('member', 'remove file success');
        $transaction = \Yii::$app->db->beginTransaction();
        //create object and validate data
        try {
            (new File())->removeFile(\Yii::$app->request->get('fileId'));
            $transaction->commit();
        } catch (\Exception $e) {
            $this->_error = true;
            $this->_message = \Yii::t('member', 'remove file error');
            $transaction->rollBack();
            return $this->sendResponse($this->_error, $this->_message, []);
        }

        return $this->sendResponse($this->_error, $this->_message, []);
    }
}
