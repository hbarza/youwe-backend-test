<?php 

namespace app\modules\Codnitive\SepMicro\models;

use app\modules\Codnitive\Core\models\DynamicModel;

class RedirectForm extends DynamicModel
{
    protected $_module = 'sepmicro';
    protected $_attributes = [/*'Amount', 'MID', 'ResNum',*/'Token', 'RedirectURL'];
    protected $_rules = [
        'required' => [/*'Amount', 'MID', 'ResNum',*/'Token', 'RedirectURL'], 
    ];
    // protected $_labels = [
    //     'country'  => 'Destination Country',
    //     'duration' => 'Duration of Stay',
    //     // 'birthday' => 'Birthday'
    //     'age' => 'Age'
    // ];
}
