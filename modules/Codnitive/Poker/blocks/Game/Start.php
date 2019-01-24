<?php 

namespace app\modules\Codnitive\Poker\blocks\Game;

use app\modules\Codnitive\Core\Module as CoreModule;
use app\modules\Codnitive\Core\blocks\Template;

class Start extends Template
{
    public function getDeckIcons()
    {
        return tools()->getOptionsArray('Poker', 'DeckIcons');
    }
}
