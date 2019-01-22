<?php

namespace app\modules\Codnitive\Core;

class Module extends \yii\base\Module
{
    public const MODULE_NAME = 'Core';

    public const MODULE_ID   = 'core';

    /**
     * Module unique id
     */
    protected $_moduleId = self::MODULE_ID;

    /**
     * Module config file path
     */
    protected $_config = __DIR__ . '/etc/config.php';

    /**
     * Parent module of exists
     */
    protected $_parent = null;

    /**
     * Register module id, parent and configurations
     */
    public function __construct()
    {
        parent::__construct($this->_moduleId, $this->_parent, require($this->_config));
    }

    /**
     * Initialize module and translations
     */
    public function init()
    {
        require_once 'App.php';
        require_once 'Tools.php';
        require_once 'ObjectManager.php';
        // \Yii::$classMap['yii\helpers\Url'] = '@app/modules/Codnitive/Core/helpers/Url.php';
        app()->on('beforeAction', function ($event) {
            app()->homeUrl = tools()->getUrl();
        });
        parent::init();
        $this->registerTranslations();
    }

    /**
     * Register module translations
     */
    public function registerTranslations()
    {
        if (isset($this->translations)) {
            app()->i18n->translations[$this->_moduleId] = $this->translations;
        }
    }

    public static function loadModules(array $modulesList)
    {
        foreach ($modulesList as $module) {
            app()->getModule($module);
        }
    }

    public function getModuleName()
    {
        return static::MODULE_NAME;
    }
}
