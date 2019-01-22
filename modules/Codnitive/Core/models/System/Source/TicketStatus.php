<?php

namespace app\modules\Codnitive\Core\models\System\Source;

class TicketStatus extends OptionsArray
{
    public function optionsArray()
    {
        return [
            1 => __('core', 'Pending'), 
            2 => __('core', 'Canceled'),
            3 => __('core', 'Confirmed'),
            100 => __('core', 'Issued'),
            101 => __('core', 'Refunded'),
        ];
    }
}
