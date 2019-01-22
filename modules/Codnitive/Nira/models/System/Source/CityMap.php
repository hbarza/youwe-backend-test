<?php

namespace app\modules\Codnitive\Nira\models\System\Source;

class CityMap /*extends \app\modules\Codnitive\Core\models\System\Source\OptionsArray*/
{
    public function optionsArray()
    {
        $module = \app\modules\Codnitive\Nira\Module::MODULE_ID;
        return [
            __($module, 'Tehran') => [
                'THR' => __($module, 'Tehran'),
                'THA' => __($module, 'TEHRAN AZADI'),
                'THB' => __($module, 'Tehran Beyhaghi'),
                'THP' => __($module, 'Tehran Ponak'),
                'THE' => __($module, 'Tehran East'),
                'THS' => __($module, 'Tehran South'),
            ],
            __($module, 'Isfahan') => [
                'IFN' => __($module, 'Isfahan'),
                'IFK' => __($module, 'Isfahan Kave'),
                'IFJ' => __($module, 'Isfahan Jey'),
                'IFS' => __($module, 'Isfahan Sofe'),
            ],
            __($module, 'Shiraz') => [
                'SYZ' => __($module, 'Shiraz'),
                'SYK' => __($module, 'Shiraz Karandish'),
                'SYA' => __($module, 'Shiraz AmirKabir'),
                'SYM' => __($module, 'Shiraz Modarres'),
            ],
            __($module, 'Rasht') => [
                'RAS' => __($module, 'Rasht'),
                'RAF' => __($module, 'Rasht Airport'),
            ],
            __($module, 'Gorgan') => [
                'GOR' => __($module, 'Gorgan'),
                'GOF' => __($module, 'Gorgan Falake Kakh'),
            ],
            __($module, 'Gonbad') => [
                'GON' => __($module, 'Gonbad'),
            ],
            __($module, 'ghaemshahr') => [
                'GHA' => __($module, 'ghaemshahr'),
            ],
            __($module, 'Bandar Anzali') => [
                'BAN' => __($module, 'Bandar Anzali'),
            ],
        ];
    }
    
    public function getSameTerminals()
    {
        $list = [];
        foreach ($this->optionsArray() as $city => $terminals) {
            foreach ($terminals as $code => $name) {
                $list[$name] = $city;
            }
        }
        return $list;
    }
}