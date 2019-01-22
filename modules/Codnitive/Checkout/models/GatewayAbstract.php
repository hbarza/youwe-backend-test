<?php 

namespace app\modules\Codnitive\Checkout\models;

use app\modules\Codnitive\Sales\models\Order;
use app\modules\Codnitive\Sales\models\Order\PaymentInfo;

abstract class GatewayAbstract
{
    public function getPaymentInfo(array $params): PaymentInfo
    {
        $paymentInfo = new PaymentInfo;
        $paymentInfo->transaction_number = $params['RefNum'];
        $paymentInfo->trace_number = $params['TRACENO'];
        return $paymentInfo;
    }
}
