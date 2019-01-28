<?php 
use app\modules\Codnitive\Poker\models\Deck;
use app\modules\Codnitive\Poker\models\Play;

class PokerTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * List of expected ordered cards deck
     * 
     * @var array
     */
    protected $deck = [
        0 => 'HA', 'H2', 'H3', 'H4', 'H5', 'H6', 'H7', 'H8', 'H9', 'H10', 'HJ', 'HQ', 'HK',
             'SA', 'S2', 'S3', 'S4', 'S5', 'S6', 'S7', 'S8', 'S9', 'S10', 'SJ', 'SQ', 'SK',
             'DA', 'D2', 'D3', 'D4', 'D5', 'D6', 'D7', 'D8', 'D9', 'D10', 'DJ', 'DQ', 'DK',
             'CA', 'C2', 'C3', 'C4', 'C5', 'C6', 'C7', 'C8', 'C9', 'C10', 'CJ', 'CQ', 'CK'
    ];
    
    // protected function _before()
    // {
    // }

    // protected function _after()
    // {
    // }

    /**
     * Testing generated poker deck in both sorted and shuffled mode
     */
    public function testDeck()
    {
        $deck = new Deck;
        $this->assertEquals($deck->getCardsDeck(), $this->deck);
        $this->assertNotEquals($deck->getCardsDeck(true), $this->deck);
    }

    /**
     * Tests play chance and score for 11th move
     */
    public function testChance()
    {
        $deck = (new Deck)->getCardsDeck(true);
        $remainingDeck = array_slice($deck, rand(0, 10), 42, true);
        $this->assertCount(42, $remainingDeck);

        end($this->deck);
        $play = new Play($this->deck[0], key($this->deck), $deck, $remainingDeck);
        $this->assertEquals(21.15, $play->calcChance());
        $this->assertEquals(4, $play->calcScore());
    }
}