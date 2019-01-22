<?php

namespace app\modules\Codnitive\Sales\actions\Account;

use yii\helpers\Json;
use app\modules\Codnitive\Sales\actions\MainAction;
use app\modules\Codnitive\Sales\models\Order;
use app\modules\Codnitive\Core\helpers\Tools;

class GetOrderDetailsAction extends MainAction
{
    public function run()
    {
        $templates = $this->_getTemplates();
        $response = [
            'items' => $templates
        ];
        return Json::encode($response);
    }

    protected function _getTemplates()
    {
        $templates = [];
        $order = (new Order)->loadOne(intval($this->_getRequest()->get('id')));
        foreach ($order->getItems() as $key => $item) {
            $templates[$key] = $this->controller->renderPartial(
                $item['product_data']['template'], 
                ['order' => $order, 'item' => $item]
            );
        }
        return $templates;
    }
}
