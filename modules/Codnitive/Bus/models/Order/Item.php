<?php 

namespace app\modules\Codnitive\Bus\models\Order;

use app\modules\Codnitive\Sales\models\Order\Item as OrderItem;
use app\modules\Codnitive\Bus\models\DataProvider;
use app\modules\Codnitive\Calendar\models\Persian;

class Item 
{
    protected $dataProvider;

    protected $_data;

    protected $_merchantId = 1;

    public function setProvider(): self
    {
        $this->dataProvider = new DataProvider($this->_data['reservation']['provider']);
        return $this;
    }

    public function getOrderItems(array $busData, int $merchantId = 1): array
    {
        $this->_data = $busData;
        $this->_merchantId = $merchantId;
        $this->setProvider();
        return [$this->getOrderItem()];
    }

    public function getOrderItem(): OrderItem
    {
        $data = $this->_data;
        $date = (new Persian)->getDate($data['departing']);
        $itemData = [
            'merchant_id' => $this->_merchantId,
            'name'        => "{$data['origin_name']} - {$data['destination_name']} (<span class=\"ltr inline-block\">$date</span>)",
            'price'       => $this->dataProvider->getFinalPrice($data['data_source']),
            'qty'         => $this->dataProvider->getSeatsCount($data['reservation']),
            'ticket_type' => 'Bus',
            'ticket_provider' => $this->_getModuleName()
        ];

        unset($data['data_source']);
        unset($data['passenger_info']);
        unset($data['payment_params']);
        unset($data['reservation']['seatmap']);
        unset($data['reservation']['rows_count']);
        
        $data['template'] = '@app/modules/Codnitive/Bus/views/templates/account/ajax/order/details.phtml';
        $itemData['product_data'] = $data;

        $item = new OrderItem;
        $item->setAttributes($itemData);
        return $item;
    }

    protected function _getModuleName()
    {
        return app()->getModule($this->_data['reservation']['provider'])->getModuleName();
    }
}
