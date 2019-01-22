<?php

namespace app\modules\Codnitive\Sales\models\Order;

use Yii;
use app\modules\Codnitive\Core\models\ActiveRecord;
// use app\modules\Codnitive\Core\helpers\Rules;
// use app\modules\Codnitive\Core\helpers\Tools;
use app\modules\Codnitive\Sales\models\Order;
// use app\modules\Codnitive\Sales\models\Order\Item\RefundInterface;

class Item extends ActiveRecord /*implements RefundInterface*/
{
    protected $_arrayFields = ['product_data'];
    protected $_parentObjectField = 'order_id';

    protected $order;

    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return '{{sales_order_item}}';
    }

    public function rules()
    {
        $rules = [
            [['order_id', 'merchant_id', 'name', 'price', 'qty', 'ticket_type', 
                'product_data', 'ticket_provider'
            ], 'safe'],
            [['order_id', 'merchant_id', 'name', 'price', 'qty', 'ticket_type',
                'ticket_provider'
            ], 'required']
        ];
        return $rules;
    }

    public function setOrderId(int $orderId): self
    {
        $this->_parentObjectId = $orderId;
        return $this;
    }

    public function saveOrderItem(
        \app\modules\Codnitive\Sales\models\Order $order, 
        \app\modules\Codnitive\Sales\models\Order\Item $item
    ) {
        $item->order_id = $order->id;
        if (!$item->validate()) {
            throw new \Exception(__('template', 'Order item data are not valid.'));
        }
        return $item->save();
    }

    public function getCollection($fieldsToSelect = ['*'])
    {
        $this->removeCollectionLimit();
        return parent::getCollection($fieldsToSelect);
    }

    public function getOrder()
    {
        if (empty($this->order)) {
            $this->order = (new Order)->loadOne($this->order_id);
        }
        return $this->order;
    }
    
    public function canRefund(): bool
    {
        if (empty($this->ticket_provider)) {
            return false;
        }
        return $this->_getProviderRefundObject()->canRefund($this);
    }

    public function refund(): array
    {
        if (!$this->canRefund()) {
            return [
                'status' => false,
                'message' => __('sales', 'Unfortunately you can not refund this ticket anymore.')
            ];
        }

        $providerRefund = $this->_getProviderRefundObject()->setOrderItem($this)->refund();
        if (-100.0 == $providerRefund) {
            $this->_changeStatus();
            return [
                'status' => false,
                'message' => __('sales', 'Ticket refunded before.')
            ];
        }
        if (-1.0 == $providerRefund) {
            return [
                'status' => false,
                'message' => __('sales', 'An error occurred when try to refund ticket, please try again.')
            ];
        }

        // @todo in future we can use payment method gateway or specific bank api
        // to refund money cash
        $wallet = getObject('\app\modules\Codnitive\Wallet\models\Gateway');
        $refundStatus = $wallet->refundAmount($providerRefund, $this->getOrder()->getOrderNumber(), $this->ticket_id);
        if (!$refundStatus) {
            return [
                'status' => false,
                'message' => __('template', 'An error occurred on refund ticket money to credit.')
            ];
        }
        $this->_changeStatus();
        return [
            'status' => true,
            'message' => __('template', '{refund_amount} was refunded to your account.', ['refund_amount' => tools()->formatRial($providerRefund)])
        ];
    }

    protected function _changeStatus(): void
    {
        $this->ticket_status = tools()->getOptionIdByValue('Core', 'TicketStatus', __('core', 'Refunded'));
        $this->save();
        if ($this->getOrder()->getItemsCount() == $this->getOrder()->getRefundedItemsCount()) {
            $this->getOrder()->setOrderRefunded();
            $this->getOrder()->save();
        }
    }

    protected function _getProviderRefundObject()
    {
        $provider = $this->ticket_provider;
        return getObject("\app\modules\Codnitive\\$provider\models\Refund");
    }

}
