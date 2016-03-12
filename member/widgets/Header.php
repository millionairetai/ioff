<?php
namespace member\widgets;
class Header extends \yii\bootstrap\Widget
{
    public function run() {
        
        return $this->render('header');
    }
}
