<?php

namespace member\controllers;

use common\models\File;
use common\models\ProjectPost;

class FileController extends ApiController {
 
    /*
     * Function remove file screen view project when click button delete
     */
    public function actionRemoveFile() {
        $file = new File();
        $result = $file->removeFile(\Yii::$app->request->get('fileId'));
        $message = $result ? \Yii::t('member', 'remove file error') : \Yii::t('member', 'remove file success');
        return $this->sendResponse($result, $message, '');
    }
}
