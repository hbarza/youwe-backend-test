<?php

namespace app\modules\Codnitive\Insurance;

class Module extends \app\modules\Codnitive\Core\Module
{
    public const MODULE_NAME = 'Insurance';

    public const MODULE_ID   = 'insurance';
    
    /**
     * Module unique id
     */
    protected $_moduleId = self::MODULE_ID;

    /**
     * Module config file path
     */
    protected $_config = __DIR__ . '/etc/config.php';

    public function init()
    {
        $products = $this->params['products'];
        // app()->params['products'][key($products)] = reset($products);
        foreach ($products as $key => $product) {
            app()->params['products'][$key] = $product;
        }
        parent::init();
    }

}
