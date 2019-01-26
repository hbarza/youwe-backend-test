<?php 
namespace app\modules\Codnitive\Poker\models;

class Play
{
    const SCORE_STARS = 5;
    /**
     * Stores player's chosen card name at fist of play
     */
    protected $_chosenCard;

    /**
     * Stores player's current move selected card
     * will use to ckeck player wins or nat and calculate player's chance
     */
    protected $_selectedCardKey;

    /**
     * Stores game full deck
     */
    protected $_deck;

    /**
     * Stores current move avaialbel deck (on each move selected card removes on controllre)
     * will use to ckeck player wins or nat and calculate player's chance
     * 
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
     */
    public function setChosenCard(string $cardName): self
    {
        $this->_chosenCard = $cardName;
        return $this;
    }

    /**
     * Getter to retrive player's chosen card
     */
    public function getChosenCard(): string
    {
        return strval($this->_chosenCard);
    }

    /**
     * Setter function to set player's current move selected card id
     */
    public function setSelectedCardKey(int $key): self
    {
        $this->_selectedCardKey = $key;
        return $this;
    }

    /**
     * Getter to retrive player's selected card in this move
     */
    public function getSelectedCardKey(): int
    {
        return intval($this->_selectedCardKey);
    }

    /**
     * Returns name of current selected card
     */
    public function getSelectedCard(): string
    {
        return $this->getDeck()[$this->getSelectedCardKey()] ?? '';
    }

    /**
     * Setter for store game original deck
     */
    public function setDeck(array $deck): self
    {
        $this->_deck = $deck;
        return $this;
    }

    public function getDeck(): array
    {
        return $this->_deck;
    }

    /**
     * Setter for define remaining cards of deck 
     */
    public function setRemainingDeck(array $deck): self
    {
        $this->_remainingDeck = $deck;
        return $this;
    }

    /**
     * Getter to retrive remaining cards deck
     */
    public function getRemainingDeck(): array
    {
        return (array) $this->_remainingDeck;
    }

    /**
     * Checks current move with chosen card to find player wins game or not
     */
    public function doesWin(): bool
    {
        // return true;
        return $this->getChosenCard() === $this->getSelectedCard();
    }

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
     */
    public function calcChance(): float
    {
        $deckCount = count($this->getDeck());
        $remainingDeckCount = count($this->getRemainingDeck()) - 1;

        return round(($deckCount - $remainingDeckCount) * 100 / $deckCount, 2);
    }

    /**
     * Calculates player score stars
     */
    public function calcScore(): int
    {
        return ceil((100 - $this->calcChance()) /  (100 / self::SCORE_STARS));
    }
}

