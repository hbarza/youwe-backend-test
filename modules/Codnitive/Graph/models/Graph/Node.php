<?php 
/**
 * Graph node object to store node info
 * Currently we working with graph nodes on the fly in Graph class, but in future
 * we can connet and store node info in database
 *
 * @author Omid Barza <hbarza@gmail.com>
 */
namespace app\modules\Codnitive\Graph\models\Graph;

use app\modules\Codnitive\Core\models\DynamicModel;

class Node extends DynamicModel
{
    /**
     * Module name to use as namespace
     * 
     */
    protected $_module = 'graph';
    
    /**
     * List of node attributes
     * 
     */
    protected $_attributes = ['node_id', 'node_value', 'prev_node', 'next_node'];

    /**
     * Validation rules for node attributes
     * 
     */
    protected $_rules = [
        'required' => ['node_id', 'node_value'], 
        'safe' => ['prev_node', 'next_node'], 
        'integer' => ['node_id'],
        'string' => ['node_value', 'options' => ['min' => 1, 'max' => 1]],
    ];
}
