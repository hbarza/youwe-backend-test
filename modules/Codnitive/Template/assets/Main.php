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
class Main extends AssetBundle
{
    // public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $sourcePath = '@app/modules/Codnitive/Template/views/assets';
    public $css = [
        'https://use.fontawesome.com/releases/v5.0.6/css/all.css',
        'css/nucleo-icons.css',
        'css/blk-design-system.css?v=1.0.0',
        'demo/demo.css',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_END];
    public $js = [
        'js/core/popper.min.js',
        'js/core/bootstrap.min.js',
        'js/plugins/perfect-scrollbar.jquery.min.js',
        'js/plugins/bootstrap-switch.js',
        'js/plugins/nouislider.min.js',
        'js/plugins/chartjs.min.js',
        'js/plugins/moment.min.js',
        'js/plugins/bootstrap-datetimepicker.js',
        'demo/demo.js',
        'js/blk-design-system.min.js?v=1.0.0"',
        'js/codnitive.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
