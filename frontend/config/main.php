<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'frontend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'frontend\controllers',
    'bootstrap' => ['log'],
	'modules' => [
 		'calendar' => [
            'class' => 'frontend\modules\calendar\calendar',
 			'defaultRoute' => 'event'
        ],
			'demo' => [
					'class' => 'frontend\modules\demo\demo',
					'defaultRoute' => 'event'
			],
    ],
    'components' => [
        'i18n' => [
            'translations' => [
                'frontend*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@frontend/messages',
                    'on missingTranslation' => ['common\components\events\TranslationEventHandler', 'handleMissingTranslation'],
                ],
            ],
        ],
        'assetManager' => [
            'appendTimestamp' => true,
        ],
//        'user' => [
//            'identityClass' => 'common\models\User',
//            'enableAutoLogin' => true,
////            'loginUrl' => ['site/sign-in'],  
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
    ],
    'params' => $params,
];
