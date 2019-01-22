<?php

namespace app\modules\Codnitive\SepMicro;

/**
 * Saman Kish (Saman Bank) Online Payment Gateway
 * 
 * Saman Electronic Payment (SEP) Micro Payment Gateway
 */
class Module extends \app\modules\Codnitive\Core\Module
{
    public const MODULE_NAME = 'SepMicro';

    public const MODULE_ID   = 'sepmicro';

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
        $payments = $this->params['payments'];
        // app()->params['payments'][key($payments)] = reset($payments);
        foreach ($payments as $key => $payment) {
            app()->params['payments'][$key] = $payment;
        }
        parent::init();
    }

}
