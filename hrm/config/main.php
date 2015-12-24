<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'hrm',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'hrm\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'i18n' => [
            'translations' => [
                'kpi*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@kpi/messages',
                    'on missingTranslation' => ['app\components\TranslationEventHandler', 'handleMissingTranslation'],
                ],
            ],
        ],
//        'user' => [
//            'identityClass' => 'common\models\User',
//            'enableAutoLogin' => true,
//        ],
//        'log' => [
//            'traceLevel' => YII_DEBUG ? 3 : 0,
//            'targets' => [
//                [
//                    'class' => 'yii\log\FileTarget',
//                    'levels' => ['error', 'warning'],
//                ],
//            ],
//        ],
//        'errorHandler' => [
//            'errorAction' => 'site/error',
//        ],
    ],
    'params' => $params,
];
