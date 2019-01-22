<?php 

namespace app\modules\Codnitive\Bus\blocks;

use app\modules\Codnitive\Core\blocks\Template;
use app\modules\Codnitive\Bus\models\DataProvider;

class SearchForm extends Template
{

    protected $_dataProvider;

    public function __construct()
    {
        $this->_dataProvider = new DataProvider;
    }

    public function getActionUrl (): string
    {
        return tools()::getUrl('bus/process/search');
    }

    public function getCities(): array
    {
        return $this->_dataProvider->getCities();
    }

    public function getOriginCities(): array
    {
        return $this->_dataProvider->getOriginCities();
    }

    public function getDestinationCities(): array
    {
        return $this->_dataProvider->getDestinationCities();
    }
    
}
