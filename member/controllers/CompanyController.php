<?php
namespace member\controllers;

use Yii;
use common\models\Action;

class CompanyController extends ApiController {
    
  /**
   * Get list of actions
   */
  public function actionIndex(){
    return $this->sendResponse(false, "", Action::getTranslation());
  }
}
