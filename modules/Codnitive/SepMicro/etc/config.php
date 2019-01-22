<?php

return [
    'components' => [
        // list of component configurations
        'translations' => [
            'class' => \yii\i18n\PhpMessageSource::className(),
            'sourceLanguage' => 'en-US',
            'basePath' => '@app/modules/Codnitive/SepMicro/i18n',
            'fileMap' => [
                'sepmicro' => 'translate.php',
            ],
        ]
    ],
    'params' => [
        // list of parameters
        'payments' => [
            // order of payment
            10 => [
                'name'           => 'SepMicro',
                'icon'           => 'fa fa-credit-card',
                'template'       => '',
                'form'           => '',
                'title'          => 'Saman Payment Gateway',
                'visibility'     => 'guest',
            ],
        ]
    ],
];
