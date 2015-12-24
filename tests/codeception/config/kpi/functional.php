<?php
$_SERVER['SCRIPT_FILENAME'] = KPI_ENTRY_FILE;
$_SERVER['SCRIPT_NAME'] = KPI_ENTRY_URL;

/**
 * Application configuration for kpi functional tests
 */
return yii\helpers\ArrayHelper::merge(
    require(YII_APP_BASE_PATH . '/common/config/main.php'),
    require(YII_APP_BASE_PATH . '/common/config/main-local.php'),
    require(YII_APP_BASE_PATH . '/kpi/config/main.php'),
    require(YII_APP_BASE_PATH . '/kpi/config/main-local.php'),
    require(dirname(__DIR__) . '/config.php'),
    require(dirname(__DIR__) . '/functional.php'),
    require(__DIR__ . '/config.php'),
    [
    ]
);
