<?php 
use app\modules\Codnitive\Graph\models\Graph;

class GraphTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * String to analyze
     * 
     * @var string
     */
    protected $phrase = 'football vs soccer';

    /**
     * Expected traverse result
     * 
     * @var array
     */
    protected $assertTraversedPhrase = [
        'f' => [
                'count' => 1,
                'before' => 'o',
                'after' => null,
                'max_distance' => null
            ],
    
        'o' => [
                'count' => 3,
                'before' => 'o,t,c',
                'after' => 'f,o,s',
                'max_distance' => 10
            ],
    
        't' => [
                'count' => 1,
                'before' => 'b',
                'after' => 'o',
                'max_distance' => null
            ],
    
        'b' => [
                'count' => 1,
                'before' => 'a',
                'after' => 't',
                'max_distance' => null
            ],
    
        'a' => [
                'count' => 1,
                'before' => 'l',
                'after' => 'b',
                'max_distance' => null 
            ],
    
        'l' => [
                'count' => 2,
                'before' => 'l,v',
                'after' => 'a,l',
                'max_distance' => 0,
            ],
    
        'v' => [
                'count' => 1,
                'before' => 's',
                'after' => 'l',
                'max_distance' => null
            ],
    
        's' => [
                'count' => 2,
                'before' => 's,o',
                'after' => 'v,s',
                'max_distance' => 1
            ],
    
        'c' => [
                'count' => 2,
                'before' => 'c,e',
                'after' => 'o,c',
                'max_distance' => 0
            ],
    
        'e' => [
                'count' => 1,
                'before' => 'r',
                'after' => 'c',
                'max_distance' => null
            ],
    
        'r' => [
                'count' => 1,
                'before' => null,
                'after' => 'e',
                'max_distance' => null
            ]
    
    ];
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    /**
     * Unit test for analyze a phrase and generage graph
     */
    public function testAnalyze()
    {
        $graph = new Graph($this->phrase);
        $this->assertInstanceOf(Graph::class, $graph);
        $graph->analyze();
        $this->assertNotEmpty($graph->getGraph());
    }

    /**
     * Unit test to test traverse graph and generate statistics
     */
    public function testTraverse()
    {
        $graph = new Graph($this->phrase);
        $graph->analyze()->traverse();
        $this->assertNotEmpty($graph->getStatistics());
        $this->assertEquals($graph->getStatistics(), $this->assertTraversedPhrase);
    }
}