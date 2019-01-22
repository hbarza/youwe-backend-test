<?php 

namespace app\modules\Codnitive\Sales\models\Order\Item;

interface ProviderRefundInterface
{
    public function setOrderItem(\app\modules\Codnitive\Sales\models\Order\Item $item);
    public function canRefund(\app\modules\Codnitive\Sales\models\Order\Item $item): bool;
    public function refund();
    public function calcRefundAmount(): float;
}
