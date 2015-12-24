<?php
use tests\codeception\kpi\AcceptanceTester;
use tests\codeception\kpi\_pages\AboutPage;

/* @var $scenario Codeception\Scenario */

$I = new AcceptanceTester($scenario);
$I->wantTo('ensure that about kpis');
AboutPage::openBy($I);
$I->see('About', 'h1');
