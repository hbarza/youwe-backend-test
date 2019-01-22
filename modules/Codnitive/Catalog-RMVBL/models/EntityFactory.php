<?php

namespace app\modules\Codnitive\Catalog\models;

use app\modules\Codnitive\Core\helpers\Tools;

class EntityFactory
{
    private $_entityModel;

    public function __construct(int $entityTypeId, int $entityId = 0)
    {
        $class = Tools::getOptionValue('Catalog', 'EntityModel', $entityTypeId);
        $this->_entityModel = (new $class)->loadOne($entityId);
    }

    public function load()
    {
        return $this->_entityModel;
    }
}
