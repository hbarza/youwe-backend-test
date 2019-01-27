<?php 
/**
 * String analyzer to analyze user input as a graph and report statistics
 * Currently we analyze string on the fly, but we can connect this model as an
 * active record to database in future to stor string and graph info
 *
 * @author Omid Barza <hbarza@gmail.com>
 */
namespace app\modules\Codnitive\Graph\models;

use app\modules\Codnitive\Graph\models\Graph\Node;

class Graph
{
    /**
     * Graph of string nodes
     * 
     * @var array
     */
    protected $_graph = [];

    /**
     * Store traversed string statistics
     * 
     * @var array
     */
    protected $_statistics = [];

    /**
     * User string to analyze
     * 
     * @var string
     */
    protected $_string = '';

    public function __construct(string $string)
    {
        $this->setString($string);
    }

    /**
     * Setter for input string to analyze
     * 
     * @param string $string
     * @return app\modules\Codnitive\Graph\models\Graph
     */
    public function setString(string $string): self
    {
        $this->_string = $string;
        return $this;
    }

    /**
     * Getter to retrive string to analyze
     * 
     * @return string
     */
    public function getString(): string
    {
        return $this->_string;
    }

    /**
     * Returns traversed string statistics
     * 
     * @return array
     */
    public function getStatistics(): array
    {
        $statistics = [];
        foreach ($this->_statistics as $nodeValue => $node) {
            $statistics[$nodeValue] = [
                'count' => $node['count'],
                'before' => implode(',', array_unique($node['before'])),
                'after' => implode(',', array_unique($node['after'])),
                // we should plus sistance start point because distance is between 
                // start and end points so we should exclude it from calculations
                'max_distance' => ($node['count'] > 1) ? $node['distance_end'] - ($node['distance_start'] + 1) : null
            ];
        }
        return $statistics;
    }

    /**
     * Add new graph node
     * 
     * @param app\modules\Codnitive\Graph\models\Graph\Node $node
     * @return app\modules\Codnitive\Graph\models\Graph
     */
    public function addNode(Node $node): self
    {
        $this->_graph[$node->node_id] = $node;
        return $this;
    }

    /**
     * Create node object to store in graph
     * 
     * @param array nodeAttributes
     * @return false | app\modules\Codnitive\Graph\models\Graph\Node
     */
    public function createNode(array $nodeAttributes)
    {
        $node = new Node;
        $node->setAttributes($nodeAttributes);
        if (!$node->validate()) {
            return false;
        }
        return $node;
    }

    /**
     * Retrive node object by node ID
     * 
     * @param in $nodeId
     * @return null | app\modules\Codnitive\Graph\models\Graph\Node
     */
    public function getNode(int $nodeId)
    {
        return isset($this->_graph[$nodeId]) ? $this->_graph[$nodeId] : null;
    }

    /**
     * String graph getter
     * 
     * @return array 
     */
    public function getGraph(): array
    {
        return $this->_graph;
    }

    /**
     * Analyze string and convert in to a graph with nodes for each character
     * 
     * @return app\modules\Codnitive\Graph\models\Graph
     */
    public function analyze(): self
    {
        $prevNodeId = null;
        foreach (str_split($this->getString()) as $id => $character) {
            if (empty(trim($character))) continue;
            $nodeAttributes = [
                'node_id' => $id,
                'node_value' => $character,
                'prev_node' => $prevNodeId
            ];
            if ($node = $this->createNode($nodeAttributes)) {
                $this->addNode($node);
            }
            if (null !== $prevNodeId  && !empty($this->getNode($prevNodeId))) {
                $prevNode = $this->getNode($prevNodeId);
                $prevNode->next_node = $id;
                $this->addNode($prevNode);
            }
            $prevNodeId = $id;
        }
        return $this;
    }

    /**
     * Traverse graph to generate statistics
     * 
     * @return app\modules\Codnitive\Graph\models\Graph
     */
    public function traverse(): self
    {
        foreach ($this->getGraph() as $id => $node) {
            if (!isset($this->_statistics[$node->node_value])) {
                $this->_statistics[$node->node_value] = [
                    'count'          => 1,
                    'distance_start' => $id,
                    'distance_end'   => $id,
                    'before'         => null !== $node->next_node ? [$this->getNode($node->next_node)->node_value] : [],
                    'after'          => null !== $node->prev_node ? [$this->getNode($node->prev_node)->node_value] : []
                ];
                continue;
            }

            $statistics = $this->_statistics[$node->node_value];
            $beforeNodeValue = null !== $node->next_node ? [$this->getNode($node->next_node)->node_value] : [];
            $afterNodeValue  = null !== $node->prev_node ? [$this->getNode($node->prev_node)->node_value] : [];
            $this->_statistics[$node->node_value] = [
                'count'          => $statistics['count'] + 1,
                'distance_start' => $statistics['distance_end'],
                'distance_end'   => $id,
                'before'         => array_merge($statistics['before'], $beforeNodeValue),
                'after'          => array_merge($statistics['after'], $afterNodeValue)
            ];
        }
        return $this;
    }

}
