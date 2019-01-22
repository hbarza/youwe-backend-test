<?php 

namespace app\modules\Codnitive\SepMicro\blocks;

class Breadcrumbs extends \app\modules\Codnitive\Template\blocks\Breadcrumbs
{
    protected $_module = 'sepmicro';
    protected $_currentClass = 'fa fa-circle-o purple';
    protected $_prevClass   = 'fa fa-circle purple';
    protected $_breadcrumbs = [
        'confirm' => [
            'title' => 'Submit Order',
        ],
        'payment' => [
            'title' => 'Redirect to Gateway',
        ],
        'success' => [
            'title' => 'Finish Checkout',
        ],
    ];
}
