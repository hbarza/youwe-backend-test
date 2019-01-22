<?php

return [
    'components' => [
        // list of component configurations
        'translations' => [
            'class' => \yii\i18n\PhpMessageSource::className(),
            'sourceLanguage' => 'en-US',
            'basePath' => '@app/modules/Codnitive/Sales/i18n',
            'fileMap' => [
                'sales' => 'translate.php',
            ],
        ]
    ],
    'params' => [
        // list of parameters
    ],
];
