<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\Codnitive\Template\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Map extends AssetBundle
{
    public $baseUrl = '@web';
    public $sourcePath = '@app/modules/Codnitive/Template/views';
    public $jsOptions = ['position' => \yii\web\View::POS_END];
    public $js = [
        'https://maps.googleapis.com/maps/api/js?key=AIzaSyB8qnL2aMVa62xQu_Vf2m9qdafTPLpLCDs&callback=initMap',
    ];
}
