<?php 

namespace app\modules\Codnitive\Bus\models;

use app\modules\Codnitive\Core\models\DynamicModel;

class SearchForm extends DynamicModel
{
    protected $_module = 'bus';
    protected $_attributes = ['origin', 'origin_name', 'destination', 
        'destination_name', 'departing', 'departing_persian'/*, 'passengers'*/
    ];
    protected $_rules = [
        'required' => ['origin', 'origin_name', 'destination', 'destination_name', 
            'departing', 'departing_persian'/*, 'passengers'*/], 
        'string' => ['origin', 'origin_name', 'destination', 'destination_name', 
            'departing', 'departing_persian']
    ];
    protected $_labels = [
        'origin'  => 'Origin',
        'destination'  => 'Destination',
        'departing'  => 'Departing Date',
        'departing_persian'  => 'Departing Date',
        // 'passengers'  => 'Passengers',
    ];
}
