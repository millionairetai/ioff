<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-member',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'member\controllers',
    'defaultRoute' => 'home/index',
    'bootstrap' => ['log'],
    'modules' => [],
    'language' => 'vi',
    'components' => [
        'user' => [
            'class' => 'common\components\web\User',
            'identityClass' => 'common\models\Employee',
            'enableAutoLogin' => true,
            'loginUrl' => ['index/login'],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                '<controller>/<action>' => '<controller>/<action>',
            ],
        ],
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'i18n' => [
            'translations' => [
                'member*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@member/messages',
                    'on missingTranslation' => ['common\components\events\TranslationEventHandler', 'handleMissingTranslation'],
                ],
            ],
        ],
        'formatter' => [
            'dateFormat' => 'dd-mm-yy',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'VND',
        ],
    ],
    'params' => $params,
];
