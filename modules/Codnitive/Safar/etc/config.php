<?php

return [
    'components' => [
        // list of component configurations
        // 'translations' => [
        //     'class' => \yii\i18n\PhpMessageSource::className(),
        //     'sourceLanguage' => 'en-US',
        //     'basePath' => '@app/modules/Codnitive/Safar/i18n',
        //     'fileMap' => [
        //         \app\modules\Codnitive\Safar\Module::MODULE_ID => 'translate.php',
        //     ],
        // ]
    ],
    'params' => [
        // list of parameters
        'bus' => [
            \app\modules\Codnitive\Safar\Module::MODULE_ID => [
                'order' => 10,
                'data_provider' => '\app\modules\Codnitive\Safar\models\DataProvider'
            ]
        ]
    ],
];
