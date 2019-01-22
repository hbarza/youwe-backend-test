<?php

namespace app\modules\Codnitive\Insurance\assets;

use yii\web\AssetBundle;

/**
 * Insurance module asset bundle.
 *
 * @author Omid <hbarza@gmail.com>
 * @since 2.0
 */
class Insurance extends AssetBundle
{
    // public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $sourcePath = '@app/modules/Codnitive/Insurance/views';
    // public $css = [
    //     // 'https://fonts.googleapis.com/css?family=Montserrat:400,700%7CVarela+Round',
    //     'css/insurance.css',
    //     // ['css/print.css', 'media' => 'print'],
    // ];
    public $jsOptions = ['position' => \yii\web\View::POS_END];
    public $js = [
        'js/insurance.js',
    ];
    // public $depends = [
    //     'app\modules\Codnitive\Template\assets\Main',
    // ];
}
