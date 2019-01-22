<?php 

namespace app\modules\Codnitive\Bus\models\Process;

use app\modules\Codnitive\Core\models\DynamicModel;

class Registration extends DynamicModel
{
    protected $_module = 'bus';
    protected $_attributes = [
        'email', 'firstname', 'lastname', 'cellphone', 'gender',
        'terms'
    ];
    protected $_rules = [
        'required' => [
            'email', 'firstname', 'lastname', 'cellphone', 'gender',
            'terms'
        ], 
        'email'  => ['email'],
        'string' => ['firstname', 'lastname'],
        // 'number' => ['cellphone'],
        'trim'   => ['email', 'cellphone'],
        // 'match' => ['cellphone', 'options' => ['pattern' => '/^[a-z]\w*$/i']],
    ];
    protected $_fieldRules = [
        'cellphone' => [
            'rule'      => 'match', 
            'options'   => ['pattern' => \app\modules\Codnitive\Core\helpers\Rules::CELLPHONE_PATTERN]
        ],
        'gender' => [
            'rule'      => 'match', 
            'options'   => ['pattern' => '/[0,1]/']
        ],
    ];
    protected $_labels = [
        'email' => 'Email',
        'firstname' => 'Firstname',
        'lastname' => 'Lastname',
        'cellphone' => 'Cell Phone',
        'gender' => 'Gender',
        'terms' => 'Terms and Conditions'
    ];
}
