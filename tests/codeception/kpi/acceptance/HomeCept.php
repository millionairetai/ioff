<?php
use tests\codeception\kpi\AcceptanceTester;

/* @var $scenario Codeception\Scenario */

$I = new AcceptanceTester($scenario);
$I->wantTo('ensure that home page kpis');
$I->amOnPage(Yii::$app->homeUrl);
$I->see('My Company');
$I->seeLink('About');
$I->click('About');
$I->see('This is the About page.');
