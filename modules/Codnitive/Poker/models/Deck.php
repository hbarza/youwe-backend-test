<?php 
namespace app\modules\Codnitive\Poker\models;

class Deck
{
    /**
     * Card suits list
     */
    protected $_suits  = ['H', 'J', 'D', 'C'];

    /**
     * Card values list
     */
    protected $_values = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];

    /**
     * Stores generated deck (if you shuffle deck, still it will store in this var)
     * 
     * @var array
     */
    protected $_deck;

    /**
     * Retrive list off all deck suits
     * 
     * @return array
     */
    public function getSuits(): array
    {
        return $this->_suits;
    }

    /**
     * Retrive list off all deck values
     * 
     * @return array
     */
    public function getValues(): array
    {
        return $this->_values;
    }

    /**
     * Generates sorted cards deck
     * 
     * @return app\modules\Codnitive\Poker\models\Deck
     */
    public function generateDeck(): self
    {
        foreach ($this->getSuits() as $suit) {
            $this->_deck[$suit] = preg_filter('/^/', $suit, $this->getValues());
        }
        return $this;
    }

    /**
     * Shuffles generated deck
     * 
     * @return app\modules\Codnitive\Poker\models\Deck
     */
    public function shuffleDeck(): self
    {
        // shuffle($this->_deck);
        foreach ($this->_deck as $suit => &$cards) {
            shuffle($cards);
        }
        $this->_deck = call_user_func_array('array_merge', $this->_deck);
        shuffle($this->_deck);
        return $this;
    }

    /**
     * Retrives cards deck, it will generate deck if needed
     * 
     * @param $shuffle  bool
     */
    public function getCardsDeck(bool $shuffle = true): array
    {
        if (empty($this->_deck)) {
            $this->generateDeck();
        }
        if ($shuffle) {
            $this->shuffleDeck();
        }
        return $this->_deck;
    }
}

