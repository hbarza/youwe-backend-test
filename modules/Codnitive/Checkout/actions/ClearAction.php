<?php

namespace app\modules\Codnitive\Checkout\actions;

use Yii;
// use yii\base\Action;
use app\modules\Codnitive\Core\actions\Action;
// use app\modules\Codnitive\Core\helpers\Tools;
// use app\modules\Codnitive\Catalog\models\Product;

class ClearAction extends Action
{
    public function run()
    {
        // $cart    = Yii::$app->cart;
        Yii::$app->cart->clear();
        return $this->controller->redirect(['/checkout/cart']);
    }
}
