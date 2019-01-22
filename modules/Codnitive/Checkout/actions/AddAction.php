<?php

namespace app\modules\Codnitive\Checkout\actions;

use Yii;
// use yii\base\Action;
use app\modules\Codnitive\Core\actions\Action;
// use app\modules\Codnitive\Core\helpers\Tools;
use app\modules\Codnitive\Catalog\models\Product;

class AddAction extends Action
{
    private $_defaultQty = 1;

    public function run()
    {
        $request = Yii::$app->request;
        $id      = $request->get('id');
        $product = (new Product)->loadOne(intval($id));
        // $cart    = Yii::$app->cart;
        $qty = $request->get('qty', $this->_defaultQty);
        if ($product->checkForAvailableQty($qty)) {
            $message = sprintf('%s was added to cart successfully.', $product->getName(true, false));
            $this->setFlash('success', $message);
            Yii::$app->cart->add($product, $qty);
        }
        else {
            $this->setFlash('danger', $product->getUnavailableMessage($qty));
        }
        return $this->controller->redirect(['/checkout/cart']);
    }
}
