<?php

namespace app\modules\Codnitive\Poker\actions;

use app\modules\Codnitive\Core\actions\Action;
use app\modules\Codnitive\Poker\models\Deck;

class PlayAction extends Action
{
    /**
     * renders playing game page and shows shuffled deck to choose
     */
    public function run()
    {
        if (!app()->session->has('poker_game')) {
            $this->setFlash('warning', __('poker', 'Time over, please start again.'));
            return $this->controller->redirect(tools()->getUrl('poker/game/start'));
        }
        
        $pokerGame = app()->session->get('poker_game');
        if (isset($pokerGame['winner'])) {
            $this->setFlash('success', __('poker', 'You finished the game, please start again.'));
            return $this->controller->redirect(tools()->getUrl('poker/game/start'));
        }

        return $this->controller->render('/templates/game/play.phtml', 
            ['deck' => $pokerGame['deck']]
        );
    }
}
