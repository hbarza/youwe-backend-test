<?php 

namespace app\modules\Codnitive\Poker\blocks\Game;

use app\modules\Codnitive\Poker\models\Play as PlayModel;

class Play extends Start
{
    /**
     * Cards deck
     */
    protected $_deck = [];

    /**
     * Remaining cards in deck
     */
    protected $_remainingDeck = [];

    public function __construct()
    {
        $this->_deck = app()->session->get('poker_game')['deck'] ?? [];
        $this->_remainingDeck = app()->session->get('poker_game')['remaining_deck'] ?? [];
    }

    /**
     * Check current card to render selected by user before or not
     * 
     * @param int $cardKey
     * @return bool
     */
    public function selectedCard(int $cardKey): bool
    {
        return !isset($this->_remainingDeck[$cardKey]);
    }

    /**
     * Retrives calculated chance for current game step
     * 
     * @return array
     */
    public function getCurrentChance(): float
    {
        return (new PlayModel)->setDeck($this->_deck)
            ->setRemainingDeck($this->_remainingDeck)
            ->calcChance();
    }

    /**
     * Retrives calculated score for current game step
     * 
     * @return array
     */
    public function getCurrentScore(): float
    {
        return (new PlayModel)->setDeck($this->_deck)
            ->setRemainingDeck($this->_remainingDeck)
            ->calcScore();
    }

    /**
     * Retruns max stars count of score
     * 
     * @return int
     */
    public function getScoreMaxStars(): int
    {
        return PlayModel::SCORE_STARS;
    }

    /**
     * Start class number
     */
    public function getStarNumber(int $i): int
    {
        return $this->getScoreMaxStars() - $i + 1;
    }
}
