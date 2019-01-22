<?php

namespace app\modules\Codnitive\Sales\models;

use Yii;
use yii\db\Transaction;
use yii\helpers\Json;
// use yii\web\ServerErrorHttpException;
use app\modules\Codnitive\Core\models\ActiveRecord;
use app\modules\Codnitive\Core\helpers\Rules;
use app\modules\Codnitive\Core\helpers\Tools;
use app\modules\Codnitive\Core\helpers\Data;
use app\modules\Codnitive\Sales\models\Order\Item;
use app\modules\Codnitive\Sales\models\System\Source\OrderStatus;
use app\modules\Codnitive\Message\models\Message\Relation;

class Order extends ActiveRecord
{
    protected $_arrayFields = ['billing_data', 'payment_info'];

    public $order_number;
    public $fullname;
    public $email;
    public $status_label;
    public $ticket_type;
    
    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return '{{sales_order}}';
    }

    public function afterFind()
    {
        $billingData     = Json::decode($this->getAttributes()['billing_data']);
        if (is_string($billingData) && tools()->isJson($billingData)) {
            $billingData = Json::decode($billingData);
        }
        $this->order_number = $this->getOrderNumber();
        $this->fullname     = $billingData['fullname'] ?? "{$billingData['firstname']} {$billingData['lastname']}";
        $this->email        = $billingData['email'] ?? '';
        $this->status_label  = Tools::getOptionValue('Sales', 'OrderStatus', $this->status);
    }

    public function rules()
    {
        $rules = [
            [['customer_id', /*'merchant_id', */'status', 'grand_total', 'order_date',
                'ticket_type', 'payment_info', 'billing_data', 'payment_method'
            ], 'safe'],
        ];
        return $rules;
    }

    protected function _prepareCollection($fieldsToSelect = ['*'])
    {
        $columns = [
            'sales_order.*',
            'sales_order_item.order_id',
            'sales_order_item.ticket_type',
        ];
        $collection = parent::_prepareCollection($columns);
        $collection = $collection->leftJoin(
            'sales_order_item', 
            "sales_order_item.order_id = sales_order.id"
        )
        ->groupBy(['sales_order.id']);
        return $collection;
    }

    public function saveOrder(
        float $grandTotal, 
        string $paymentMethod, 
        \app\modules\Codnitive\Sales\models\Order\BillingData $billingData, 
        array $items
    ) {
        try {
            // @todo add like this validation to action to check and validate user data
            if (!$billingData->validate()) {
                throw new \Exception(__('template', 'Billing data are not valid.'));
            }
            $data = [
                'customer_id'       => $this->_getUserId(),
                // 'status'            => (new OrderStatus)->getOptionIdByValue(OrderStatus::PENDING_PAYMENT),
                'status'            => (new OrderStatus)->getOptionIdByValue(OrderStatus::PROCESSING),
                'grand_total'       => $grandTotal,
                'billing_data'      => $billingData->getAttributes(),
                'payment_method'    => $paymentMethod,
                'order_date'        => date('Y-m-d H:i:s'),
            ];
            
            if ($result = $this->setData($data)->save()) {
                $result = $this->_saveItems($items);
            }
            if ($result) {
                return $this->loadOne($this->id);
            }
            return false;
        }
        catch (\Exception $e) {
            $errorNumber = Data::log($e, 'SmO');
            // $message = $e->getMessage();
            Data::setFlash('danger', __('template', 'Error occurred when saving order.') . "\n<br>" . $errorNumber);
            return false;
        }
    }

    protected function _saveItems(array $items)
    {
        try {
            $transaction = Yii::$app->db->beginTransaction(
                Transaction::SERIALIZABLE
            );
            foreach ($items as $item) {
                if (!($result = (new Item)->saveOrderItem($this, $item))) {
                    throw new \Exception($result);
                }
                // (new Relation)->saveMessageRelation($item, $this->id);
            }
            $transaction->commit();
        }
        catch (\Exception $e) {
            $transaction->rollBack();
            $errorNumber = Data::log($e, 'SmOI');
            // throw new ServerErrorHttpException($errorNumber);
            Data::setFlash('danger', __('template', 'Error occurred when saving order items.') . "\n<br>" . $errorNumber);
            return false;
        }
        return $result;
    }

    public function saveTicketItemsData(array $ticketsData)
    {
        try {
            $transaction = Yii::$app->db->beginTransaction(
                Transaction::SERIALIZABLE
            );
            foreach ($this->getItems() as $item) {
                $item = $this->_addTicketData($item, $ticketsData[$item->id]);
                if (!($result = $item->save())) {
                    throw new \Exception($result);
                }
            }
            $transaction->commit();
        }
        catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
        return true;
    }

    protected function _addTicketData(
        \app\modules\Codnitive\Sales\models\Order\Item $item,
        \app\modules\Codnitive\Sales\models\Order\Item\TicketData $ticketData
    ) {
        if (!$ticketData->validate()) {
            throw new \Exception(__('template', 'Ticket data not valid.'));
        }

        $ticketInfo  = $ticketData->getAttributes();
        $item->ticket_provider = $ticketInfo['ticket_provider'];
        $item->ticket_id = $ticketInfo['ticket_id'];
        $item->ticket_number = $ticketInfo['ticket_number'];
        $item->ticket_status = $ticketInfo['ticket_status'];
        if (isset($ticketInfo['product_data'])) {
            $item->product_data = $ticketInfo['product_data'];
        }

        return $item;
    }

    public function setSuccessPayment(\app\modules\Codnitive\Sales\models\Order\PaymentInfo $paymentInfo): self
    {
        $this->payment_info = $paymentInfo;
        return $this->changeOrderStatus(OrderStatus::COMPLETED);
    }

    public function setOrderProcessing(): self
    {
        return $this->changeOrderStatus(OrderStatus::PROCESSING);
    }

    public function setOrderPendingPayment(): self
    {
        return $this->changeOrderStatus(OrderStatus::PENDING_PAYMENT);
    }

    public function setOrderCancel(): self
    {
        return $this->changeOrderStatus(OrderStatus::CANCELED);
    }

    public function setOrderRefunded(): self
    {
        return $this->changeOrderStatus(OrderStatus::REFUNDED);
    }

    public function changeOrderStatus(string $status): self
    {
        $this->status = tools()->getOptionIdByValue('Sales', 'OrderStatus', __('sales', $status));
        // $this->status = (new OrderStatus)->getOptionIdByValue($status);
        // $this->save();
        return $this;
    }

    public function getItems()
    {
        $item     = new Item;
        $items    = $item->setOrderId($this->id);
        if ($this->_isReceivedOrders()) {
            $items->andWhere(['merchant_id' => $this->_getUserId()]);
        }
        return $items->getCollection();
    }

    public function getItemsCount()
    {
        $item     = new Item;
        $items    = $item->setOrderId($this->id);
        return $items->countCollection();
    }

    public function getRefundedItemsCount()
    {
        $item     = new Item;
        $items    = $item->setOrderId($this->id);
        $items->andWhere(['ticket_status' => tools()->getOptionIdByValue('Core', 'TicketStatus', __('core', 'Refunded'))]);
        return $items->countCollection();
    }

    public function getOrderNumber($url = false, $orderId = 0)
    {
        $orderId = $orderId ?: $this->id;
        $orderNumber = sprintf('1%011d', $orderId);
        if (!Tools::isGuest() && $url) {
            $orderNumber = '<a href="'.$this->getOrderUrl($orderId).'">'.$orderNumber.'</a>';
        }
        return $orderNumber;
    }

    public function getGrandTotal($items)
    {
        $grandTotal = $this->grand_total;
        if ($this->_isReceivedOrders()) {
            $grandTotal = 0;
            foreach ($items as $item) {
                $grandTotal += $item->qty * $item->price;
            }
        }
        return $grandTotal;
    }

    public function getOrderUrl($orderId = 0)
    {
        return Tools::getUrl(
            'account/sales/order', 
            ['id' => $orderId ?: $this->id]
        );
    }

    protected function _isReceivedOrders()
    {
        return boolval(Yii::$app->request->get('received', 0));
    }

    protected function _getUserId()
    {
        return Tools::isGuest() 
            ? \app\modules\Codnitive\Account\models\User::GUEST_USER_ID 
            : Tools::getUser()->getId();
    }

}
