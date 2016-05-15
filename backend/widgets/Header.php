<?php
namespace backend\widgets;
class Header extends \yii\bootstrap\Widget
{
    public function run() {
        
        return $this->render('header');
    }
}
