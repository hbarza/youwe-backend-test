<?php
/**
 * Playing game ajax action
 *
 * @author Omid Barza <hbarza@gmail.com>
 */
namespace app\modules\Codnitive\Poker\actions\Ajax;

use yii\helpers\Json;
use app\modules\Codnitive\Core\actions\Action;
use app\modules\Codnitive\Poker\models\Play;

class CheckPlayAction extends Action
{
    /**
     * Disbale CSRF validation because we don't have form
     */
    public function init()
    {
        parent::init();
        app()->controller->enableCsrfValidation = false;    
    }

    /**
     * cleans session and renders ordered cards deck
     * 
     * @return string (json)
     */
    public function run()
    {
        $selectedCard = intval(app()->getRequest()->get('key', -1));
        if (-1 === $selectedCard) {
            return Json::encode(['status' => false, 'message' => __('poker', 'Please select a card')]);
        }
        $pokerGame = $this->_updatePokerGame($selectedCard);
        $play = new Play(
            $pokerGame['chosen_card'],
            $selectedCard,
            $pokerGame['deck'],
            $pokerGame['remaining_deck']
        );
        
        if ($play->doesWin()) {
            $play->setWinner();
            $response = [
                'status' => true,
                'message' => __('poker', 'Got it, the chance was {chance}%', ['chance' => $play->calcChance()]),
                'chance' => $play->calcChance(),
                'score' => $play->calcScore(),
                'selected_card' => tools()->getOptionValue('Poker', 'DeckIcons', $play->getSelectedCard()),
            ];
        }
        else {
            $response = [
                'status' => false,
                'message' => '',
                'chance' => $play->calcChance(),
                'score' => $play->calcScore(),
                'selected_card' => tools()->getOptionValue('Poker', 'DeckIcons', $play->getSelectedCard())
            ];
        }
        return Json::encode($response);
    }

    /**
     * Updates game session
     * 
     * @return array
     */
    private function _updatePokerGame(int $selectedCard): array
    {
        $pokerGame = app()->session->get('poker_game');
        unset($pokerGame['remaining_deck'][$selectedCard]);
        app()->session->set('poker_game', $pokerGame);
        return $pokerGame;
    }
}
