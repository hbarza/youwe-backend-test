<?php 

namespace app\modules\Codnitive\Bus\models;

use app\modules\Codnitive\Core\models\DynamicModel;

class SeatReserveForm extends DynamicModel
{
    protected $_module = 'bus';
    protected $_attributes = ['provider', 'bus_id', 'discount', 'seat_numbers',
        'company', 'boarding', 'dropping', 'price', 'departure', 'seatmap', 'rows_count'
    ];
    protected $_rules = [
        'required' => ['provider', 'bus_id', 'discount', 'seat_numbers',
            'company', 'boarding', 'dropping', 'price', 'departure', 'seatmap', 'rows_count'
        ], 
    ];
    protected $_labels = [
        'provider' => 'Provider',
        'bus_id'  => 'Bus ID',
        'discount' => 'Discount',
        'seat_numbers'  => 'Seat Numbers',
    ];
}
