<?php 
/**
 * Start page content block class
 *
 * @author Omid Barza <hbarza@gmail.com>
 */
namespace app\modules\Codnitive\Poker\blocks\Game;

use app\modules\Codnitive\Core\Module as CoreModule;
use app\modules\Codnitive\Core\blocks\Template;

class Start extends Template
{
    /**
     * Returns deck icons array to show game start page deck
     * 
     * @return array
     */
    public function getDeckIcons(): array
    {
        return tools()->getOptionsArray('Poker', 'DeckIcons');
    }
}
