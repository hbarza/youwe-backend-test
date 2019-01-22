<?php

namespace app\modules\Codnitive\Sales\models\System\Source;

use app\modules\Codnitive\Core\models\System\Source\OptionsArray;

class OrderStatus extends OptionsArray
{
    const PENDING           = 'Pending';
    const PENDING_PAYMENT   = 'Pending Payment';
    const PROCESSING        = 'Processing';
    const COMPLETED         = 'Completed';
    const CANCELED          = 'Canceled';
    const ON_HOLD           = 'On Hold';
    const REFUNDED          = 'Refunded';

    public function optionsArray()
    {
        return [
            1 =>  __('sales', self::PENDING),
            __('sales', self::PENDING_PAYMENT),
            __('sales', self::PROCESSING),
            __('sales', self::COMPLETED),
            __('sales', self::CANCELED),
            __('sales', self::ON_HOLD),
            __('sales', self::REFUNDED),
        ];
    }
}
