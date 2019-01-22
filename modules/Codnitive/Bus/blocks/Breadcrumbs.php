<?php 

namespace app\modules\Codnitive\Bus\blocks;

class Breadcrumbs extends \app\modules\Codnitive\Template\blocks\Breadcrumbs
{
    protected $_module = 'bus';
    protected $_currentClass = 'fa fa-bus color';
    protected $_prevClass   = 'fa fa-circle color';
    protected $_breadcrumbs = [
        'buses' => [
            'title' => 'Choose Bus',
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
            'title' => 'Get Ticket',
        ],
    ];
}
