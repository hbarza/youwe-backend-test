<?php 

namespace app\modules\Codnitive\Insurance\blocks;

class Breadcrumbs extends \app\modules\Codnitive\Template\blocks\Breadcrumbs
{
    protected $_module = 'insurance';
    protected $_currentClass = 'icon-insurance color fz-25';
    protected $_prevClass   = 'fa fa-circle color';
    protected $_breadcrumbs = [
        'plans' => [
            'title' => 'Choose Plan',
        ],
        'info' => [
            'title' => 'Passangers Information',
        ],
        'confirm' => [
            'title' => 'Confirm and Payment',
        ],
        // 'payment' => [
        //     'title' => 'Payment',
        // ],
        'success' => [
            'title' => 'Get Insurance',
        ],
    ];
}
