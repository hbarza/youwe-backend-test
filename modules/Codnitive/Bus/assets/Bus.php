<?php

namespace app\modules\Codnitive\Bus\assets;

use yii\web\AssetBundle;

/**
 * Insurance module asset bundle.
 *
 * @author Omid <hbarza@gmail.com>
 * @since 2.0
 */
class Bus extends AssetBundle
{
    // public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $sourcePath = '@app/modules/Codnitive/Bus/views';
    public $css = [
        // 'https://fonts.googleapis.com/css?family=Montserrat:400,700%7CVarela+Round',
        'css/bus.css',
        // ['css/print.css', 'media' => 'print'],
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_END];
    public $js = [
        'js/bus.js',
    ];
    public $depends = [
        'app\modules\Codnitive\Bus\assets\SeatCharts',
    ];
}
