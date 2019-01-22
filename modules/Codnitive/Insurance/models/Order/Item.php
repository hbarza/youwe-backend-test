<?php 

namespace app\modules\Codnitive\Insurance\models\Order;

use app\modules\Codnitive\Sales\models\Order\Item as OrderItem;

class Item 
{
    protected $_merchantId = 1;

    public function getOrderItems(array $insurances, int $merchantId = 1): array
    {
        $this->_merchantId = $merchantId;
        $items = [];
        foreach ($insurances as $key => $insurance) {
            $items[$insurance->bimehNo] = $this->getOrderItem($insurance);
        }
        return $items;
    }

    public function getOrderItem($insurance): OrderItem
    {
        $insurance = json_decode(json_encode($insurance), true);
        $itemData = [
            'merchant_id' => $this->_merchantId,
            'name'        => $insurance['plan']['title'],
            'price'       => $insurance['price']['priceGross'],
            'qty'         => 1,
            'ticket_type' => 'Insurance',
            'ticket_provider' => \app\modules\Codnitive\Insurance\Module::MODULE_NAME
        ];

        unset($insurance['plan']['covers']);
        $insurance['template'] = '@app/modules/Codnitive/Insurance/views/templates/account/ajax/order/details.phtml';
        $itemData['product_data'] = $insurance;

        $item = new OrderItem;
        $item->setAttributes($itemData);
        return $item;
    }
}
