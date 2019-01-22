<?php

namespace app\modules\Codnitive\Core\models\System\Source;

class Sort extends OptionsArray
{
    public function optionsArray()
    {
        return [
            'inexpensive' => __('core', 'Sort by Inexpensive'),
            'expensive'   => __('core', 'Sort by Expensive'),
            'newest'      => __('core', 'Sort by Newest'),
            'oldest'      => __('core', 'Sort by Oldest'),
            'current'     => __('core', 'Sort by Current'),
            'future'      => __('core', 'Sort by Future'),
        ];
    }
}
