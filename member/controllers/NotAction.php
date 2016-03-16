<?php
namespace member\controllers;

use yii\base\Action;

class NotAction extends Action
{
    public function run()
    {
        $this->controller->layout = "login";
        return $this->controller->render('errors');
    }
}

