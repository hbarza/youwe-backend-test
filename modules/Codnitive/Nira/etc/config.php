<?php

return [
    'components' => [
        // list of component configurations
        'translations' => [
            'class' => \yii\i18n\PhpMessageSource::className(),
            'sourceLanguage' => 'en-US',
            'basePath' => '@app/modules/Codnitive/Nira/i18n',
            'fileMap' => [
                \app\modules\Codnitive\Nira\Module::MODULE_ID => 'translate.php',
            ],
        ]
    ],
    'params' => [
        // list of parameters
        'bus' => [
            \app\modules\Codnitive\Nira\Module::MODULE_ID => [
                'order' => 20,
                'data_provider' => '\app\modules\Codnitive\Nira\models\DataProvider'
            ]
        ]
    ],
];
