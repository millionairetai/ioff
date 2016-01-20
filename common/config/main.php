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
            'defaultRoute' => 'default'
        ],
    ],
    'components' => [
//        'cache' => [
//            'class' => 'yii\caching\FileCache',
//        ],
        'authManager' => [
            'class' => 'common\modules\authority\AuthorityManager',
            'allowCache' => false,
        ],
        'user' => [
            'class' => 'common\modules\authority\User',
            'identityClass' => 'common\models\Employee',
            'enableAutoLogin' => true,
            'loginUrl' => ['site/login'],  
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
                    'on missingTranslation' => ['common\components\events\TranslationEventHandler', 'handleMissingTranslation'],
                ],
            ],
        ],
//        'assetManager' => [
//            'appendTimestamp' => true,
//        ],
    ],
    'params' => [
        'defaultPackage' => 'work'
    ],
];
