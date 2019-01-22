<?php

namespace app\modules\Codnitive\Catalog\models\System\Source;

use app\modules\Codnitive\Core\models\System\Source\OptionsArray;

class EntityType extends OptionsArray
{
    public function optionsArray()
    {
        return [
            1 => 'Event'
        ];
    }
}
