<?php 

namespace app\modules\Codnitive\Sales\models\Order\Item;

use app\modules\Codnitive\Sales\models\Order\Item;

abstract class ProviderRefundAbstract
{
    protected $item;

    public function __construct(Item $item = null)
    {
        if ($item instanceof Item) {
            $this->setOrderItem($item);
        }
    }

    public function setOrderItem(Item $item): self
    {
        $this->item = $item;
        return $this;
    }
    
    public function canRefund(\app\modules\Codnitive\Sales\models\Order\Item $item): bool
    {
        // check item ticket_status for showing refund if it's refunded, show refunded message
        // also check order if is completed should show button
        // @todo check for ticket status which if is refunded before return this false
        if ($item->ticket_status == tools()->getOptionIdByValue('Core', 'TicketStatus', __('core', 'Refunded'))) {
            return false;
        }
        $date = new \DateTime();
        $now  = $date->format('Y-m-d\TH:i:s');
        $orderDate = $item->getOrder()->order_date;
        return tools()->minutesDiff($orderDate, $now) <= 60 * 24;
    }
}
