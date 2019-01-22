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
class Location extends AssetBundle
{
    public $baseUrl = '@web';
    public $sourcePath = '@app/modules/Codnitive/Template/views';
    public $jsOptions = ['position' => \yii\web\View::POS_END];
    public $js = [
        'https://maps.googleapis.com/maps/api/js?key=AIzaSyBJlvxq36apfwv8iSSP9mb1V6tpCPc0a08&libraries=places',
    ];
    public $depends = [
        'app\modules\Codnitive\Template\assets\Main',
    ];
}
