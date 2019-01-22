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
    public $sourcePath = '@app/modules/Codnitive/Template/views';
    public $css = [
        // 'https://fonts.googleapis.com/css?family=Montserrat:400,700%7CVarela+Round',
        'css/bootstrap.min.css',
        // 'css/bootstrap-rtl.min.css',
        'css/font-awesome.all.min.css',
        'css/style-font.css',
        'css/style.css',
        // 'css/main-styles-rtl.css',
        // 'css/respnsive-rtl.css',
        // ['css/print.css', 'media' => 'print'],
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_END];
    public $js = [
        // 'js/jquery-3.2.1.min.js',
        'js/popper.min.js',
        'js/bootstrap.min.js',
        'js/jquery.validate.min.js',
        'js/codnitive.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
