<?php

namespace app\modules\Codnitive\Sales\models\Account\Order\ReceivedOrder;

use Yii;
use yii\helpers\Html;
use app\modules\Codnitive\Core\helpers\Tools;
use app\modules\Codnitive\Core\models\Grid\GridAbstract;

class Grid extends GridAbstract
{
    protected $_modelClass      = '\app\modules\Codnitive\Sales\models\Order';
    protected $_actionsTemplate = '{view}';
    
    public function __construct()
    {
        parent::__construct();
        $this->_sortAttributes = ['id', 'order_number', 'fullname', 'email', 'grand_total', 
            'order_date', 'payment_method', 'status_label'];
        $this->_columns = ['sales_order.id', 'grand_total', 'order_date', 
            'billing_data', 'payment_method', 'status'];
    }

    protected function _prepareDataCollection($columns = [])
    {
        // $collection = $this->_modelObject->prepareCollection($columns);
        $collection = parent::_prepareDataCollection($columns);
        $collection->leftJoin('sales_order_item', 'sales_order_item.order_id = sales_order.id');
        return $collection->andWhere(['sales_order_item.merchant_id' => Tools::getUser()->id]);
    }

    protected function _prepareColumnsFormat()
    {
        return [
            'id',
            'order_number',
            // [
            //     'attribute' => 'order_number',
            //     'value' => function ($model) {
            //         return $model->getOrderNumber();
            //     },
            // ],
            'fullname',
            // [
            //     'attribute' => 'fullname',
            //     // 'format' => 'html',
            //     'value' => function ($model) {
            //         return $model->billing_data['fullname'];
            //     },
            // ],
            'email',
            // [
            //     'attribute' => 'email',
            //     'value' => function ($model) {
            //         return $model->billing_data['email'];
            //     },
            // ],
            'order_date',
            // [
            //     'attribute' => 'order_date',
            //     'label' => 'Order Date',
            //     // 'format'     => ['date', 'php:d/m/Y H:i:s']
            // ],
            [
                'attribute' => 'grand_total',
                'contentOptions' => ['class' => 'text-right'],
                'value' => function ($model) {
                    return Tools::formatMoney($model->grand_total);
                },
            ],
            'payment_method',
            [
                'attribute' => 'status_label',
                'label' => 'Status'
                // 'value' => function ($model) {
                //     return Tools::getOptionValue('Sales', 'OrderStatus', $model->status);
                // },
            ],
        ];
    }

    protected function _getActionButtons()
    {
        return [
            'view' => function ($url, $model) {
                return Html::a('<span class="btn btn-info">View</span>', $url, [
                    'title' => __('app', 'View'),
                ]);
            }
        ];
    }

    protected function _getActionUrls($action, $model, $key, $index)
    {
        $url = $model->getOrderUrl();
        return "$url&received=1";
        // return Tools::getUrl(
        //     'account/sales/order',
        //     ['id' => $key]
        // );
    }
}
