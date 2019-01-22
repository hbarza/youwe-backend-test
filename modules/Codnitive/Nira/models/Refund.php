<?php 

namespace app\modules\Codnitive\Nira\models;

use app\modules\Codnitive\Sales\models\Order\Item;

class Refund extends \app\modules\Codnitive\Sales\models\Order\Item\ProviderRefundAbstract
    implements \app\modules\Codnitive\Sales\models\Order\Item\ProviderRefundInterface
{

    public function __construct(Item $item = null)
    {
        parent::__construct($item);
    }

    public function refund(): float
    {
        $refundAmount = $this->calcRefundAmount();
        $selectedBus = $this->item->product_data['selected_bus'];
        $refund = (new Nira)->refundTicket(
            $this->item->ticket_id,
            $selectedBus['company_id'],
            $selectedBus['origin_id']
        );
        if (isset($refund['ERR']) && 'No Error' == $refund['ERR'] && $refundAmount >= 0) {
            return $refundAmount;
        }
        if (isset($refund['ERR']) && 'PNR seats was Refunded' == $refund['ERR']) {
            return -100.0;
        }
        return -1.0;
    }

    public function calcRefundAmount(): float
    {
        $selectedBus = $this->item->product_data['selected_bus'];
        $penalty = (new Nira)->getRefundPenalty(
            explode(',', $this->item->ticket_number)[0],
            $selectedBus['company_id'],
            $selectedBus['origin_id']
        );
        if (!isset($penalty['CashPayment'])) {
            return -1.0;
        }
        $eachTicketRerundableAmount = $penalty['CashPayment'];
        return (float) $eachTicketRerundableAmount * (new DataProvider)->getSeatsCount($this->item->product_data['reservation']);
    }
}
