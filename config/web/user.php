<?php

// $config['components']['user'] = [
//     'loginUrl' => [\app\modules\Codnitive\Core\helpers\Tools::getUrl('accountssdf/login')],
// ];

//override template
$config['components']['view'] = [
        'theme' => [
            'pathMap' => [
                '@dektrium/user/views' => '@app/modules/Codnitive/Account/views'
                // '@dektrium/user/views' => '@app/views/user',
            ],
        ],
];
$config['modules']['user'] = [
    'class' => 'dektrium\user\Module',
    'modelMap' => [
        // 'RegistrationForm' => 'app\models\RegistrationForm',
        // 'Profile' => 'app\models\Profile',
        'User'              => 'app\modules\Codnitive\Account\models\User',
        'SettingsForm'      => 'app\modules\Codnitive\Account\models\SettingsForm',
        'LoginForm'         => 'app\modules\Codnitive\Account\models\LoginForm',
        'RegistrationForm'  => 'app\modules\Codnitive\Account\models\RegistrationForm',
    ],
    'enableFlashMessages' => false,
    // override controller
    'controllerMap' => [
        'admin'         => 'app\modules\Codnitive\Account\controllers\AdminController',
        'profile'       => 'app\modules\Codnitive\Account\controllers\ProfileController',
        'recovery'      => 'app\modules\Codnitive\Account\controllers\RecoveryController',
        // 'registration'  => 'app\modules\Codnitive\Account\controllers\RegistrationController',
        // 'security'      => 'app\modules\Codnitive\Account\controllers\SecurityController',
        'settings'      => 'app\modules\Codnitive\Account\controllers\SettingsController',
        'security'  => [
            // 'class' => \dektrium\user\controllers\RegistrationController::className(),
            'class' => 'app\modules\Codnitive\Account\controllers\SecurityController',
            'on ' . \dektrium\user\controllers\SecurityController::EVENT_BEFORE_LOGIN => function ($e) {
                if (\Yii::$app->request->get('prev_url')) {
                    \yii\helpers\Url::remember([\Yii::$app->request->get('prev_url')], 'prev_url');
                }
                if (!preg_match('/(fa|en)/', tools()->getCurrentUrl())) {
                    \Yii::$app->response->redirect(tools()->getUrl('user/login'));
                }
            },
            'on ' . \dektrium\user\controllers\SecurityController::EVENT_AFTER_LOGIN => function ($e) {
                if ($url = \yii\helpers\Url::previous('prev_url')) {
                    \Yii::$app->getSession()->remove('prev_url');
                    \Yii::$app->response->redirect($url)->send();
                    \Yii::$app->end();
                }
                app()->user->returnUrl = tools()->getUrl(app()->user->returnUrl);
            }
        ],
        'registration'  => [
            // 'class' => \dektrium\user\controllers\RegistrationController::className(),
            'class' => 'app\modules\Codnitive\Account\controllers\RegistrationController',
            'on ' . \dektrium\user\controllers\RegistrationController::EVENT_BEFORE_REGISTER => function ($e) {
                // if ((int) \Yii::$app->request->get('remember_cart')) {
                //     \yii\helpers\Url::remember(['/checkout/cart'], 'cart_url');
                // }
                if (\Yii::$app->request->get('prev_url')) {
                    \yii\helpers\Url::remember([\Yii::$app->request->get('prev_url')], 'prev_url');
                }
            },
            'on ' . \dektrium\user\controllers\RegistrationController::EVENT_AFTER_REGISTER => function ($e) {
                \Yii::$app->response->redirect(['user/security/login'])->send();
                \Yii::$app->end();
            }
        ],
    ],
    'admins' => ['09205203613'],
];
