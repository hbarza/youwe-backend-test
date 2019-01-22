<?php

namespace app\modules\Codnitive\Safar;

/**
 * Seiro Safar Nira API Module
 */
class Module extends \app\modules\Codnitive\Core\Module
{
    public const MODULE_NAME = 'Safar';

    public const MODULE_ID = 'safar';

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
        $busConfig = $this->params['bus'];
        foreach ($busConfig as $key => $config) {
            app()->params['bus'][$key] = $config;
        }
        parent::init();
    }

}
