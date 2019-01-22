<?php

namespace app\modules\Codnitive\Insurance\models\System\Source;

class Gender extends \app\modules\Codnitive\Core\models\System\Source\OptionsArray
{
    public function optionsArray()
    {
        return [
            1 => __('core', 'Male'),
            2 => __('core', 'Female')
        ];
    }
}
