<?php 
/**
 * String analyzer form to get user input string
 *
 * @author Omid Barza <hbarza@gmail.com>
 */
namespace app\modules\Codnitive\Graph\models;

use app\modules\Codnitive\Core\models\DynamicModel;

class Form extends DynamicModel
{
    /**
     * Module name to use as form namesapace
     * 
     */
    protected $_module = 'graph';
    
    /**
     * List of form fields and attributes
     * 
     */
    protected $_attributes = ['string'];

    /**
     * Form Validation rules
     * 
     */
    protected $_rules = [
        'required' => ['string'], 
        'string' => ['string', 'options' => ['min' => 3, 'max' => 255]],
    ];

    /**
     * Fields and attributes labels
     * 
     */
    protected $_labels = [
        'string'  => 'String',
    ];
}
