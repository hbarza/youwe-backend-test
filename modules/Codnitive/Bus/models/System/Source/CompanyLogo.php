<?php

namespace app\modules\Codnitive\Bus\models\System\Source;

use app\modules\Codnitive\Core\models\System\Source\OptionsArray;

class CompanyLogo extends OptionsArray
{
    public function optionsArray()
    {
        return [
            '11321006-11231' => 'tavoni7.png',
            '11321004-11947' => 'tavoni7.png',
            '31310000-31112' => 'tavoni7.png',
            '11321006-11766' => 'seirosafarjonoob.png',
            '11321007-11962' => 'tavoni17.png',
            '11321004-11957' => 'tavoni17.png',
            '31310000-31586' => 'tavoni17.png',
            '11321006-11223' => 'taavoni5.png',
            '11321006-11235' => 'tavoni9.png',
            '31310000-31461' => 'tavoni9.png',
            '11321004-11943' => 'tavoni3.png',
            '31310000-31638' => 'tavoni3.png',
            '11321006-11807' => 'taavoni6.png',
            '11321006-11219' => 't04.jpg',
            '11321004-11944' => 't04.jpg',
            '11321004-11851' => 'MAHAN.jpg',
            '31310000-31092' => 'seirosafarjonoob.png',
            '31310000-31131' => 'giti.png',
            '31310000-31896' => 'royalgharb.png',
            '31310000-31580' => 'taavoni5.png',
            '31310000-31592' => 'ariasafarmashhad.jpg',
            '31310000-31528' => 'ariasafarmashhad.jpg',
            '31310000-31675' => 'lavan.jpg',
            '31310000-31544' => 't15mashhad.jpg',
            '31310000-31522' => 'tavoni1jonob.png',
            '31310000-31093' => 'tavoni1jonob.png',
            '31310000-31636' => 'taksafar.jpg',
            '31310000-31581' => 'paykmotamed.jpg',
            '31310000-31588' => 'maralsair.jpg',
            '31310000-31448' => 'chaboksaran.png',
            '11321004-11956' => 't16black.png',
        ];
    }

    public function getOptionValue($id)
    {
        // default icon placeholder https://www.iconfinder.com/icons/2851753/bus_land_school_transportation_vehicle_icon
        return isset(($this->optionsArray())[$id]) ? ($this->optionsArray())[$id] : 'placeholder.png';
    }
}
