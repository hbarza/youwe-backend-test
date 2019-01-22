<?php

namespace app\modules\Codnitive\Account;

class Module extends \app\modules\Codnitive\Core\Module
{
    public const MODULE_NAME = 'Account';

    public const MODULE_ID   = 'account';

    /**
     * Module unique id
     */
    protected $_moduleId = self::MODULE_ID;

    /**
     * Module config file path
     */
    protected $_config = __DIR__ . '/etc/config.php';

}
