<?php 
/**
 * Game play model
 *
 * @author Omid Barza <hbarza@gmail.com>
 */
namespace app\modules\Codnitive\Poker\models;

class Play
{
    const SCORE_STARS = 5;
    /**
     * Stores player's chosen card name at fist of play
     * 
     * @var string
     */
    protected $_chosenCard;

    /**
     * Stores player's current move selected card
     * will use to ckeck player wins or nat and calculate player's chance
     * 
     * @var int
     */
    protected $_selectedCardKey;

    /**
     * Stores game full deck
     * 
     * @var array
     */
    protected $_deck;

    /**
     * Stores current move avaialbel deck (on each move selected card removes on controllre)
     * will use to ckeck player wins or nat and calculate player's chance
     * 
     * @var array
     */
    protected $_remainingDeck;

    public function __construct(string $chosenCardName = '', int $selectedCardKey = 0, array $deck = [], array $remainingDeck = [])
    {
        $this->setChosenCard($chosenCardName)
            ->setSelectedCardKey($selectedCardKey)
            ->setDeck($deck)
            ->setRemainingDeck($remainingDeck);
    }
    
    /**
     * Setter to save players chosen card
     * 
     * @param string $cardName
     * @return app\modules\Codnitive\Poker\models\Play
     */
    public function setChosenCard(string $cardName): self
    {
        $this->_chosenCard = $cardName;
        return $this;
    }

    /**
     * Getter to retrive player's chosen card
     * 
     * @return string
     */
    public function getChosenCard(): string
    {
        return strval($this->_chosenCard);
    }

    /**
     * Setter function to set player's current move selected card id
     * 
     * @param int $key card key in deck array
     * @return app\modules\Codnitive\Poker\models\Play
     */
    public function setSelectedCardKey(int $key): self
    {
        $this->_selectedCardKey = $key;
        return $this;
    }

    /**
     * Getter to retrive player's selected card in this move
     * 
     * @return int
     */
    public function getSelectedCardKey(): int
    {
        return intval($this->_selectedCardKey);
    }

    /**
     * Returns name of current selected card
     * 
     * @return string
     */
    public function getSelectedCard(): string
    {
        return $this->getDeck()[$this->getSelectedCardKey()] ?? '';
    }

    /**
     * Setter for store game original deck
     * 
     * @param array $deck
     * @return app\modules\Codnitive\Poker\models\Play
     */
    public function setDeck(array $deck): self
    {
        $this->_deck = $deck;
        return $this;
    }

    /**
     * Getter to get game deck
     * 
     * @return array
     */
    public function getDeck(): array
    {
        return $this->_deck;
    }

    /**
     * Setter for define remaining cards of deck 
     * 
     * @param array $deck
     * @return app\modules\Codnitive\Poker\models\Play
     */
    public function setRemainingDeck(array $deck): self
    {
        $this->_remainingDeck = $deck;
        return $this;
    }

    /**
     * Getter to retrive remaining cards deck
     * 
     * @return array
     */
    public function getRemainingDeck(): array
    {
        return (array) $this->_remainingDeck;
    }

    /**
     * Checks current move with chosen card to find player wins game or not
     * 
     * @return bool
     */
    public function doesWin(): bool
    {
        return $this->getChosenCard() === $this->getSelectedCard();
    }

    /**
     * Set and update session parameter when player wins the game
     * 
     * @return app\modules\Codnitive\Poker\models\Play
     */
    public function setWinner(): self
    {
        $pokerGame      = app()->session->get('poker_game');
        $remainingDeck  = $this->getRemainingDeck();
        $remainingDeck['winner'] = $pokerGame['winner'] = $this->getSelectedCard();
        $this->setRemainingDeck($remainingDeck);
        app()->session->set('poker_game', $pokerGame);
        return $this;
    }

    /**
     * Claculates player chance on current move
     * 
     * @return float
     */
    public function calcChance(): float
    {
        $deckCount = count($this->getDeck());
        $remainingDeckCount = count($this->getRemainingDeck()) - 1;

        return round(($deckCount - $remainingDeckCount) * 100 / $deckCount, 2);
    }

    /**
     * Calculates player score stars
     * 
     * @return int
     */
    public function calcScore(): int
    {
        return ceil((100 - $this->calcChance()) /  (100 / self::SCORE_STARS));
    }
}

