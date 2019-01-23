<?php

$params = require __DIR__ . '/params.php';
$db     = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log', // @TODO comment out on production
        
        // added by default to work enywhere
        // [
        //     'class' => 'app\modules\Codnitive\Language\LanguageSelector',
        //     // 'supportedLanguages' => ['en-US', 'fa-IR'],
        // ],
        'core',
        'language',
        'template',
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'Hra_c2PhWw5TNOsUb-JzGJWhs9e615SkO',
        ],
        'cache' => [
            // 'class' => 'yii\caching\FileCache',
            // @TODO replace with redis
            'class' => 'yii\caching\ApcCache',
            'useApcu' => true,
            'keyPrefix' => 'bilit.com-',
            // change cache life time based on trafic
            'defaultDuration' => 60 * 10,
        ],
        'user' => [
            'identityClass' => 'dektrium\user\models\User',
            'enableAutoLogin' => true,
        ],
        /*'errorHandler' => [
            'errorAction' => 'site/error',
        ],*/
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => $db,
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    // 'basePath' => '@app/messages', // if advanced application, set @frontend/messages
                    // 'sourceLanguage' => 'en-US',
                    // 'fileMap' => [
                    //     'main' => 'main.php',
                    // ],
                ],
            ],
        ],
    ],
    'params' => $params,
    // 'on beforeAction' => function ($event) {
    //     \Yii::$app->language = \app\modules\Codnitive\Core\helpers\Tools::getOptionValue('Core', 'Langi18n', \Yii::$app->request->get('lang'));
    // },
];

require __DIR__ . '/web/url_manager.php';
require __DIR__ . '/web/codnitive.php';

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
