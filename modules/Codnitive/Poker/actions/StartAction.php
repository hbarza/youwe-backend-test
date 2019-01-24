<?php

namespace app\modules\Codnitive\Poker\actions;

use app\modules\Codnitive\Core\actions\Action;
use app\modules\Codnitive\Poker\models\Deck;

class StartAction extends Action
{
    public function run()
    {
        return $this->controller->render(
            '/templates/game/start.phtml', 
            ['deck' => (new Deck)->getCardsDeck(false, true)]
        );
    }
}
