<?php 

namespace app\modules\Codnitive\Insurance\models\Plans;

use app\modules\Codnitive\Core\models\DynamicModel;

class Registration extends DynamicModel
{
    protected $_module = 'insurance';
    protected $_attributes = [
        'persian_name', 'persian_lastname', 'english_name', 'english_lastname', 
        'national_id', 'passport_no', 'email', 'cellphone', 'gender'/*, 'gender_drop'*/, 
        'visa_type', 'birthday', 'birthday_persian', 'removed',
        'terms'
    ];
    protected $_rules = [
        'required' => [
            'persian_name', 'persian_lastname', 'english_name', 'english_lastname', 
            'national_id', 'passport_no', 'gender'/*, 'gender_drop'*/, 'visa_type', 
            'birthday', 'birthday_persian', 'email', 'cellphone', 'removed',
            'terms'
        ],
        'email'  => ['email'],
        'string' => ['persian_name', 'persian_lastname', 'english_name', 'english_lastname'],
        'trim'   => ['national_id', 'passport_no', 'email', 'cellphone'],
    ];
    protected $_fieldRules = [
        'cellphone' => [
            'rule'      => 'match', 
            'options'   => ['pattern' => \app\modules\Codnitive\Core\helpers\Rules::CELLPHONE_PATTERN]
        ],
        'national_id' => [
            'rule'      => 'match', 
            'options'   => ['pattern' => \app\modules\Codnitive\Core\helpers\Rules::IRANIAN_NATIONAL_ID]
        ],
        'gender' => [
            'rule'      => 'match', 
            'options'   => ['pattern' => '/[1,2]/']
        ],
        'visa_type' => [
            'rule'      => 'match', 
            'options'   => ['pattern' => '/[1,2]/']
        ],
        'removed' => [
            'rule'      => 'match', 
            'options'   => ['pattern' => \app\modules\Codnitive\Core\helpers\Rules::BOOLEAN_PATTERN]
        ],
    ];
    protected $_labels = [
        'persian_name'  => 'Persian Name',
        'persian_lastname' => 'Persian Lastname',
        'english_name' => 'English Name',
        'english_lastname' => 'English Lastname',
        'national_id' => 'National ID',
        'passport_no' => 'Passport No.',
        'email' => 'Email',
        'cellphone' => 'Cell Phone',
        'gender' => 'Gender',
        // 'gender_drop' => 'Gender',
        'visa_type' => 'Visa Type',
        'birthday' => 'Birthday',
        'birthday_persian' => 'Birthday',
        'terms' => 'Terms and Conditions'
    ];
}
