<?php

namespace app\modules\Codnitive\Bus\actions\Account;

use app\modules\Codnitive\Core\actions\Action;
// use app\modules\Codnitive\Sales\models\Order;
use app\modules\Codnitive\Sales\models\Order\Item;
use app\modules\Codnitive\Bus\models\DataProvider;

class TicketAction extends Action
{
    public function run()
    {
        $this->controller->layout = '@app/modules/Codnitive/Account/views/layouts/print';
        $ticketId = app()->getRequest()->get('id');
        $item  = (new Item)->loadOne(intval($ticketId));
        // $order = (new Order)->loadOne(intval($item->order_id));
        
        $dataProvider = new DataProvider($item->product_data['reservation']['provider']);
        $ticket = $dataProvider->getTicketPrintData($item->product_data['ticket'], $item->getOrder());

        return $this->controller->render('/templates/ticket.phtml', [
            'ticket' => $ticket,
            'print' => true
        ]);
    }
}
