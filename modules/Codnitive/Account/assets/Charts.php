<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\Codnitive\Account\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Charts extends AssetBundle
{
    public $baseUrl = '@web';
    public $sourcePath = '@app/modules/Codnitive/Account/views';
    /*public $css = [
    ];*/
    public $jsOptions = ['position' => \yii\web\View::POS_END];
    public $js = [
        'js/sb-admin-charts.min.js',
    ];
    public $depends = [
        'app\modules\Codnitive\Account\assets\Tixox',
    ];
}
