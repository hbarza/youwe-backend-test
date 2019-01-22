<?php 

namespace app\modules\Codnitive\Bus\models\Order;

use app\modules\Codnitive\Core\models\DynamicModel;

class TicketPrintData extends DynamicModel
{
    protected $_module = 'sales';
    protected $_attributes = ['order_number', 'payment_trace_number', 
        'fullname', 'issue_date', 'issue_time', 'departure_date', 'departure_time',
        'origin', 'boarding', 'destination', 'dropping', 'company',
        'ticket_number', 'pnr', 'seats_count', 'seat_numbers', 'price'
    ];
    protected $_rules = [
        'required' => ['order_number', 'payment_trace_number', 
            'fullname', 'issue_date', 'issue_time', 'departure_date', 'departure_time',
            'origin', 'boarding', 'destination', 'dropping', 'company', 
            'ticket_number', 'seats_count', 'seat_numbers', 'price'
        ], 
        'safe' => ['pnr'],
    ];
}