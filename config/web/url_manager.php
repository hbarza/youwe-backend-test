<?php
/**
 * @NOTICE: the order of url manager files is important and must be load and merge
 * with this order
 */
$generalRoutes    = require __DIR__ . '/url_manager/general_routes.php';

$config['components']['urlManager'] = [
    'class' => 'yii\web\UrlManager',
    // Disable index.php
    'showScriptName' => false,
    // Disable r= routes
    'enablePrettyUrl' => true,
    'enableStrictParsing' => false,
    // 'suffix' => '.html',
    'rules' => array_merge([
            [
                'pattern' => '<lang:\w{2}>',
                'route' => '',
            ],
        ],
        $generalRoutes
    ),
];
