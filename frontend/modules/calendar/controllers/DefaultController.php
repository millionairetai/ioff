<?php
/**
 * @author minh-tha
 * @create date 2016-01-06
 */
namespace work\modules\calendar\controllers;

use common\controllers\CeController;

class DefaultController extends CeController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
