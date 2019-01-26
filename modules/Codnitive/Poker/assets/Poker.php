<?php
/**
 * Poker module asset bundle
 *
 * @author Omid Barza <hbarza@gmail.com>
 */
namespace app\modules\Codnitive\Poker\assets;

use yii\web\AssetBundle;

class Poker extends AssetBundle
{
    public $baseUrl = '@web';
    public $sourcePath = '@app/modules/Codnitive/Poker/views/assets';
    
    public $jsOptions = ['position' => \yii\web\View::POS_END];
    public $js = [
        'js/poker.js',
    ];
    public $depends = [
        'app\modules\Codnitive\Template\assets\Main',
    ];
}
