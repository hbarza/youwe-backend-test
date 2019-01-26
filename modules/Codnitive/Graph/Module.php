<?php
/**
 * Module declaration class
 *
 * @author Omid Barza <hbarza@gmail.com>
 */
namespace app\modules\Codnitive\Graph;

/**
 * Graph module for string analyzer test
 */
class Module extends \app\modules\Codnitive\Core\Module
{
    public const MODULE_NAME = 'Graph';

    public const MODULE_ID = 'graph';
    /**
     * Module unique id
     */
    protected $_moduleId = self::MODULE_ID;

    /**
     * Module config file path
     */
    protected $_config = __DIR__ . '/etc/config.php';

}
