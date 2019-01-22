<?php

namespace app\modules\Codnitive\Core\models\System\Source;

class YesNo extends OptionsArray
{
    public function optionsArray()
    {
        return [
            1 => __('insurance', 'Yes'), 
            0 => __('insurance', 'No')
        ];
    }
}
