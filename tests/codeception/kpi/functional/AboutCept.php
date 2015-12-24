<?php
use tests\codeception\kpi\FunctionalTester;
use tests\codeception\kpi\_pages\AboutPage;

/* @var $scenario Codeception\Scenario */

$I = new FunctionalTester($scenario);
$I->wantTo('ensure that about kpis');
AboutPage::openBy($I);
$I->see('About', 'h1');
