<?php

namespace app\modules\Codnitive\Insurance\models\System\Source;

class Status extends \app\modules\Codnitive\Core\models\System\Source\OptionsArray
{
    public function optionsArray()
    {
        return [
            1 => __('insurance', 'Pending'), 
            2 => __('insurance', 'Canceled'),
            3 => __('insurance', 'Confirmed'),
        ];
    }
}
