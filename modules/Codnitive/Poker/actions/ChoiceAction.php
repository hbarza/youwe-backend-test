<?php

namespace app\modules\Codnitive\Poker\actions;

use app\modules\Codnitive\Core\actions\Action;
use app\modules\Codnitive\Poker\models\Deck;

class ChoiceAction extends Action
{
    /**
     * Retrives user chosen card and generates a shuffled deck and store those
     * in session to make ready user for play
     */
    public function run()
    {
        $chosenCard  = app()->getRequest()->get('card', '');
        if (empty($chosenCard)) {
            $this->setFlash('info', __('poker', 'Please choose a card.'));
            return $this->controller->redirect(tools()->getUrl('poker/game/start'));
        }
        
        app()->session->set('poker_game', [
            'chosen_card' => $chosenCard,
            'deck' => (new Deck)->getCardsDeck(true)
        ]);
        return $this->controller->redirect(tools()->getUrl('poker/game/play'));
    }
}
