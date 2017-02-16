<?php
return [
    'language' => 'en',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'common\components\web\AuthorityManager',
            'allowCache' => false,
        ],
        'user' => [
            'class' => 'common\components\web\User',
            'identityClass' => 'common\models\Employee',
//            'enableAutoLogin' => true,
//            'loginUrl' => ['site/login'],  
        ],
        'i18n' => [
            'translations' => [
                'common*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'on missingTranslation' => ['common\components\events\TranslationEventHandler', 'handleMissingTranslation'],
                ],
                'member*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@member/messages',
                    'on missingTranslation' => ['common\components\events\TranslationEventHandler', 'handleMissingTranslation'],
                ],
            ],
        ],
    ],
];
