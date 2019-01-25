<?php

namespace app\modules\Codnitive\Poker\actions;

use app\modules\Codnitive\Core\actions\Action;
use app\modules\Codnitive\Poker\models\Deck;

class StartAction extends Action
{
    /**
     * cleans session and renders ordered cards deck
     */
    public function run()
    {
        app()->session->remove('poker_game');
        return $this->controller->render(
            '/templates/game/start.phtml', 
            ['deck' => (new Deck)->getCardsDeck()]
        );
    }
}
