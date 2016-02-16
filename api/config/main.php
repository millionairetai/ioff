<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'user' => [
            'class' => 'common\components\web\User',
            'identityClass' => 'common\models\Employee',
//            'enableAutoLogin' => true,
//            'loginUrl'=>'auth/unauthorized',
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
            'errorAction' => 'api/error',
        ],
        'response' => [
            //set default format is json
            'on beforeSend' => function ($event) {
              $response = $event->sender;
              $response->format = yii\web\Response::FORMAT_JSON;
              //api\helpers\Response::populateOject($response->data);
            }
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            'showScriptName' => false,
//            'rules' => require (__DIR__ . '/urlRules.php')
        ],
        'i18n' => [
            'translations' => [
                'api*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@api/messages',
//                    'on missingTranslation' => ['common\components\events\TranslationEventHandler', 'handleMissingTranslation'],
                ],
            ],
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];