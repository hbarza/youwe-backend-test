<?php 
namespace app\modules\Codnitive\Bus\blocks;

use app\modules\Codnitive\Calendar\models\Persian;
use app\modules\Codnitive\Bus\models\SearchForm;

class Toolbar extends \app\modules\Codnitive\Bus\blocks\SearchForm
{
    protected function _getSearchParams()
    {
        return app()->session->get('__virtual_cart')['bus'];
    }

    public function getSearchParams()
    {
        return $this->_getSearchParams();
    }

    public function getDate()
    {
        return (new Persian)->getDate($this->_getSearchParams()['departing']);
    }

    public function getFormModel($day)
    {
        $date = new \DateTime($this->_getSearchParams()['departing']);
        $departing = $date->modify($day)->format('Y-m-d');
        $departing = (new Persian)->getDate($departing);
        
        $searchForm = new SearchForm;
        $searchForm->attributes = [
            'origin_name' => $this->_getSearchParams()['origin_name'],
            'origin' => $this->_getSearchParams()['origin'],
            'destination' => $this->_getSearchParams()['destination'],
            'destination_name' => $this->_getSearchParams()['destination_name'],
            'departing' => $departing,
        ];
        return $searchForm;
    }
}
