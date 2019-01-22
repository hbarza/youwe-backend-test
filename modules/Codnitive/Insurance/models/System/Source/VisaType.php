<?php

namespace app\modules\Codnitive\Insurance\models\System\Source;

class VisaType extends \app\modules\Codnitive\Core\models\System\Source\OptionsArray
{
    public function optionsArray()
    {
        return [
            1 => __('insurance', 'Single'), 
            2 => __('insurance', 'Multi')
        ];
    }
}
