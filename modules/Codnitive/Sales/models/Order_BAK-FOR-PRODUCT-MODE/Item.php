<?php

namespace app\modules\Codnitive\Sales\models\Order;

use Yii;
use app\modules\Codnitive\Core\models\ActiveRecord;
// use app\modules\Codnitive\Core\helpers\Rules;
// use app\modules\Codnitive\Core\helpers\Tools;

class Item extends ActiveRecord
{
    protected $_parentObjectField = 'order_id';

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
            [['order_id', 'merchant_id', 'name', 'price', 'qty', 'ticket_type'
            ], 'safe']
        ];
        return $rules;
    }

    public function setOrderId($orderId)
    {
        $this->_parentObjectId = $orderId;
        return $this;
    }

    public function saveOrderItem($order, $cartItem)
    {
        $entityModel = $cartItem->getProduct()->entity_model;
        $itemData = [
            'order_id'    => $order->id,
            'qty'         => $cartItem->getQuantity(),
            'ticket_type' => $entityModel::TICKET_TYPE
        ];

        $itemData += $cartItem->getProduct()->attributes;
        if ($result = $this->setData($itemData)->save()) {
            $result = $this->_updateQty($cartItem);
        }
        return $result;
    }

    /**
     * decreas order qty from product to update available qty of product
     */
    protected function _updateQty($cartItem)
    {
        $product = $cartItem->getProduct();

        $model  = (new $product->price_model)->loadOne($product->price_id);
        $model->qty -= $cartItem->getQuantity();
        $result = $model->save();

        $condition = $result && (!intval($product->price_id) || $product->price == 0.0000);
        if ($condition) {
            $qty   = $model->qty;
            $model = (new $product->entity_model)->loadOne($product->entity_id);
            $model->tickets_qty = $qty;
            // $model->tickets_qty -= $cartItem->getQuantity();
            $result = $model->save();
        }

        return $result;
    }

    public function getCollection($fieldsToSelect = ['*'])
    {
        $this->removeCollectionLimit();
        return parent::getCollection($fieldsToSelect);
    }

}
