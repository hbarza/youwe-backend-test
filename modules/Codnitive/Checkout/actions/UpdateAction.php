<?php

namespace app\modules\Codnitive\Checkout\actions;

use Yii;
// use yii\base\Action;
use app\modules\Codnitive\Core\actions\Action;
// use app\modules\Codnitive\Core\helpers\Tools;
// use app\modules\Codnitive\Catalog\models\Product;

class UpdateAction extends Action
{
    public function run()
    {
        $qtys = Yii::$app->request->post('item_qty');
        // $cart = Yii::$app->cart;
        foreach ($qtys as $productId => $qty) {
            if ($qty <= 0) {
                Yii::$app->cart->remove($productId);
                continue;
            }
            Yii::$app->cart->change($productId, $qty);
        }
        $this->setFlash('success', 'Cart was updated successfully');
        return $this->controller->redirect(['/checkout/cart']);
    }
}
