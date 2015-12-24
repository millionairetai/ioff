<?php

return [
    'id' => 'common',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'common\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'vi',
//    'sourceLanguage' => 'vi',
    'modules' => [
        'authority' => [
            'class' => 'common\modules\authority\Authority',
        ],
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'common\models\Employee',
            'enableAutoLogin' => true,
//            'loginUrl' => ['site/sign-in'],  
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
        'i18n' => [
            'translations' => [
                'common*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'on missingTranslation' => ['app\components\TranslationEventHandler', 'handleMissingTranslation'],
                ],
            ],
        ],
    ],
//    'on beforeRequest' => ['common\components\checkIfLogin', 'checkIfLogin'],
    'params' => [
        'defaultPackage' => 'work'
    ],
];
