<?php

namespace app\modules\Codnitive\Checkout\actions;

use Yii;
use app\modules\Codnitive\Core\actions\Action;
// use app\modules\Codnitive\Core\helpers\Tools;
use app\modules\Codnitive\Sales\models\Order;

class SuccessAction extends Action
{
    public function run()
    {
        $this->controller->setBodyClass('my-check-out success');
        $orderId = Yii::$app->request->get('order_id');
        if (empty($orderId)) {
            return $this->controller->redirect(['/checkout/cart']);
        }
        $order   = (new Order)->loadOne($orderId);

        return $this->controller->render(
            '/success', 
            ['order' => $order]
        );
    }

}
