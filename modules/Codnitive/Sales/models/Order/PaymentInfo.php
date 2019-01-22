<?php 

namespace app\modules\Codnitive\Sales\models\Order;

use app\modules\Codnitive\Core\models\DynamicModel;

class PaymentInfo extends DynamicModel
{
    protected $_module = 'sales';
    protected $_attributes = ['transaction_number', 'trace_number'];
    protected $_rules = [
        'required' => ['transaction_number', 'trace_number'], 
    ];
}