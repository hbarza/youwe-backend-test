<?php 

namespace app\modules\Codnitive\Insurance\models;

use app\modules\Codnitive\Core\models\DynamicModel;

class SearchForm extends DynamicModel
{
    protected $_module = 'insurance';
    protected $_attributes = ['country_name', 'country', 'duration'/*, 'birthday'*/, 'age'];
    protected $_rules = [
        'required' => ['country_name', 'country', 'duration'/*, 'birthday'*/, 'age'], 
    ];
    protected $_labels = [
        'country'  => 'Destination Country',
        'duration' => 'Duration of Stay',
        // 'birthday' => 'Birthday'
        'age' => 'Age'
    ];
}
