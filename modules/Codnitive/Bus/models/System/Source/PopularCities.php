<?php

namespace app\modules\Codnitive\Bus\models\System\Source;

use app\modules\Codnitive\Core\models\System\Source\OptionsArray;

class PopularCities extends OptionsArray
{
    public function optionsArray()
    {
        return [
            __('language', 'Tehran'),
            __('language', 'Mashhad'),
            __('language', 'Tabriz'),
            __('language', 'Esfahan'),
            __('language', 'Shiraz'),
            __('language', 'Ahvaz'),
            __('language', 'Yazd'),
            __('language', 'Rasht'),
            __('language', 'Arak'),
            __('language', 'Oromie'),
            __('language', 'Ardebil'),
            __('language', 'Kermanshah'),
            __('language', 'Gorgan'),
            // __('language', 'Sari'),
        ];
    }
}
