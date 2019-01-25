<?php 
namespace app\modules\Codnitive\Poker\models;

class Play
{
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
     * Stores current move avaialbel deck (on each move selected card removes on controllre)
     * will use to ckeck player wins or nat and calculate player's chance
     * 
     */
    protected $_remainingDeck;

    public function __construnct(string $cardName = '', int $key = 0, array $deck = [])
    {
        $this->setChosenCard($cardName)
            ->setMoveCardKey($key)
            ->setRemainingDeck($deck);
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
        return $this->getRemainingDeck()[$this->getSelectedCardKey()] ?? '';
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
        return (array) $this->_chosenCard;
    }

    /**
     * Checks current move with chosen card to find player wins game or not
     */
    public function doesWon(): bool
    {
        dump($this->getChosenCard());
        dump($this->getSelectedCard());
        exit;
        return $this->getChosenCard() === $this->getSelectedCard();
    }
}

