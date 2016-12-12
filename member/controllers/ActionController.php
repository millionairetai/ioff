<?php
namespace member\controllers;

use Yii;
use common\models\Action;

class ActionController extends ApiController {
    
  /**
   * Get list of actions
   */
  public function actionIndex(){
    return $this->sendResponse(false, "", Action::getTranslation());
  }
}
