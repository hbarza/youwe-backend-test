<?php

namespace app\modules\Codnitive\Bus\assets;

use yii\web\AssetBundle;

/**
 * Insurance module asset bundle.
 *
 * @author Omid <hbarza@gmail.com>
 * @since 2.0
 */
class SeatCharts extends AssetBundle
{
    // public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $sourcePath = '@app/modules/Codnitive/Bus/views';
    public $css = [
        'SeatCharts/jquery.seat-charts.css',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_END];
    public $js = [
        'SeatCharts/jquery.seat-charts.min.js',
    ];
    public $depends = [
        'app\modules\Codnitive\Template\assets\Main',
    ];
}
