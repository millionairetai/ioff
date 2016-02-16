<?php

namespace api\controllers;

use Yii;
use common\components\web\StatusMessage;

class ProjectController extends ApiController {
    
    public function actionReport() {
        return ['project' => 'default'];
    }
}