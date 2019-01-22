<?php

return [
    'components' => [
        // list of component configurations
        'translations' => [
            'class' => \yii\i18n\PhpMessageSource::className(),
            'sourceLanguage' => 'en-US',
            'basePath' => '@app/modules/Codnitive/Bus/i18n',
            'fileMap' => [
                'bus' => 'translate.php',
            ],
        ]
    ],
    'params' => [
        // list of parameters
        'products' => [
            // order of tab
            20 => [
                'name'           => 'box-bus',
                'icon'           => 'icon-bus',
                'content_id'     => 'tab-bus',
                'template'       => '@app/modules/Codnitive/Bus/views/templates/index/search/bus.form.phtml',
                'about_template' => '@app/modules/Codnitive/Bus/views/templates/index/about.phtml',
                // 'slide'          => '@app/modules/Codnitive/Bus/views/templates/index/slide.phtml',
                'form'           => 'bus/ajax/searchForm',
                'title'          => 'Bus',
                'title_class'    => 'color',
                'color'          => 'pink',
                'color_code'     => '#ff0487',
            ],
        ]
    ],
];
