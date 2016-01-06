<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'work',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'work\controllers',
    'bootstrap' => ['log'],
	'modules' => [
 		'calendar' => [
            'class' => 'work\modules\calendar\calendar',
        ],
    ],
    'components' => [
        'i18n' => [
            'translations' => [
                'work*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@work/messages',
                    'on missingTranslation' => ['common\components\events\TranslationEventHandler', 'handleMissingTranslation'],
                ],
            ],
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
