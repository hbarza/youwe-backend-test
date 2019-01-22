<?php

namespace app\modules\Codnitive\Catalog\models\System\Source;

use app\modules\Codnitive\Core\models\System\Source\OptionsArray;

class EntityModel extends OptionsArray
{
    public function optionsArray()
    {
        return [
            1 => 'app\modules\Codnitive\Event\models\Event'
        ];
    }
}
