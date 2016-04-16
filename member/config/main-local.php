<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '9WBwz6xMNmH8euMyj_dxn9Q6c4935up5',
        ],
        'db' => [
            'class' => 'common\components\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=new_centeroffice',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
    ],
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
//    $config['bootstrap'][] = 'debug';
//    $config['modules']['debug'] = [
//        'class' => 'yii\debug\Module',
//    ];
//
//    $config['bootstrap'][] = 'gii';
//    $config['modules']['gii'] = [
//        'class' => 'yii\gii\Module',
//    ];
}

return $config;
