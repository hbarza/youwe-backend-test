<?php

return [
    'components' => [
        // list of component configurations
        'translations' => [
            'class' => \yii\i18n\PhpMessageSource::className(),
            'sourceLanguage' => 'en-US',
            'basePath' => '@app/modules/Codnitive/Calendar/i18n',
            'fileMap' => [
                'calendar' => 'translate.php',
            ],
        ]
    ],
    'params' => [
        // list of parameters
    ],
];
