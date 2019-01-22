<?php

namespace app\modules\Codnitive\Message;

class Module extends \yii\base\Module
{
    public const MODULE_NAME = 'Message';

    public const MODULE_ID   = 'message';

    /**
     * Module unique id
     */
    protected $_moduleId = self::MODULE_ID;

    public function init()
    {
        parent::init();
        \Yii::configure($this, require(__DIR__ . '/etc/config.php'));
    }
}
