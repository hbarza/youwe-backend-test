<?php

namespace app\modules\Codnitive\Nira\models\System\Source;

use app\modules\Codnitive\Core\models\System\Source\OptionsArray;

class FixCityName extends OptionsArray
{
    public function optionsArray()
    {
        $module = \app\modules\Codnitive\Nira\Module::MODULE_ID;
        return [
            __($module, 'Gonbad') => __($module, 'Gonbad Kavoos'),
            __($module, 'ghaemshahr') => __($module, 'Ghaem Shahr'),
            __($module, 'Bandar Anzali') => __($module, 'Bandaranzali'),
            __($module, 'AY') => __($module, 'PY'),
        ];
    }

    public function getFindCities()
    {
        return array_keys($this->optionsArray());
    }

    public function getReplaceCities()
    {
        return array_values($this->optionsArray());
    }
}
