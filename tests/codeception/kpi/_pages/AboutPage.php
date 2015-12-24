<?php

namespace tests\codeception\kpi\_pages;

use yii\codeception\BasePage;

/**
 * Represents about page
 * @property \codeception_kpi\AcceptanceTester|\codeception_kpi\FunctionalTester $actor
 */
class AboutPage extends BasePage
{
    public $route = 'site/about';
}
