<?php

return [
    'components' => [
        // list of component configurations
        'translations' => [
            'class' => \yii\i18n\PhpMessageSource::className(),
            'sourceLanguage' => 'en-US',
            'basePath' => '@app/modules/Codnitive/Insurance/i18n',
            'fileMap' => [
                'insurance' => 'translate.php',
            ],
        ]
    ],
    'params' => [
        // list of parameters
        'products' => [
            // order of tab
            30 => [
                'name'           => 'box-insurance',
                'icon'           => 'icon-insurance',
                'content_id'     => 'tab-insurance',
                'template'       => '@app/modules/Codnitive/Insurance/views/templates/index/search/insurance.form.phtml',
                'about_template' => '@app/modules/Codnitive/Insurance/views/templates/index/about.phtml',
                // 'slide'          => '@app/modules/Codnitive/Insurance/views/templates/index/slide.phtml',
                'form'           => 'insurance/ajax/searchForm',
                'title'          => 'Insurance',
                'title_class'    => 'color',
                'color'          => 'purple',
                'color_code'     => '#a22bff',
            ],
        ]
    ],
];
