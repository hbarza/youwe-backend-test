<?php

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
     */
    public function run()
    {
        $selectedCard = app()->getRequest()->get('key', '');
        if (!$selectedCard) {
            return Json::encode(['status' => false, 'message' => __('poker', 'Please select a card')]);
        }
        $play = new Play(
            app()->session->get('poker_game')['chosen_card'],
            $selectedCard,
            app()->session->get('poker_game')['deck'],
        );

        dump($play->doesWon());
        exit;

        $response = [
            'element' => '.ajax-result-wrapper',
            'type'    => 'html',
            'content' => '$message'
        ];

        return Json::encode($response);
    }
}
