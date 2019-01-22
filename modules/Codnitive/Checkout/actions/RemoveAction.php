<?php

namespace app\modules\Codnitive\Checkout\actions;

use Yii;
// use yii\base\Action;
use app\modules\Codnitive\Core\actions\Action;
// use app\modules\Codnitive\Core\helpers\Tools;
// use app\modules\Codnitive\Catalog\models\Product;

class RemoveAction extends Action
{
    public function run()
    {
        $id      = Yii::$app->request->get('id');
        // $cart    = Yii::$app->cart;
        $this->setFlash('success', 'Item removed from cart.');
        Yii::$app->cart->remove($id);
        return $this->controller->redirect(['/checkout/cart']);
    }
}
