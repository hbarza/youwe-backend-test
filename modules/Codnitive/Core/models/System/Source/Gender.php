<?php

namespace app\modules\Codnitive\Core\models\System\Source;

class Gender extends OptionsArray
{
    public function optionsArray()
    {
        return [
            0 => __('core', 'Female'), 
            1 => __('core', 'Male')
        ];
    }
}
