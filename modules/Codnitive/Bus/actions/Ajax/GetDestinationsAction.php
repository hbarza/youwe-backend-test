<?php

namespace app\modules\Codnitive\Bus\actions\Ajax;

use yii\helpers\Json;
use app\modules\Codnitive\Core\actions\Action;
use app\modules\Codnitive\Bus\models\DataProvider;
use app\modules\Codnitive\Bus\blocks\City;

/**
 * Method which calls with ajax to retive avaliable buses
 * 
 * @route   bus/ajax/getDestinations
 */
class GetDestinationsAction extends Action
{
    /**
     * Disbale CSRF validation for loading search form
     */
    public function init()
    {
        parent::init();
        app()->controller->enableCsrfValidation = false;    
    }

    /**
     * get request form params and retrives available plans, then generates 
     * block template and return response
     */
    public function run()
    {
        $searchParams   = $this->_getRequest()->post();
        $dataProvider   = new DataProvider;
        $cities         = $dataProvider->getDestinationCities($searchParams['origin'], $searchParams['origin_name']);
        // $cities         = $dataProvider->getDestinationCities('safar:21310000;nira:IFK;nira:IFJ;nira:IFS');
        $options        = (new City)->getSelectOptions($cities, __('bus', 'Destination'));

        $response = [
            [
                'element' => '#bus-destination',
                'type'    => 'html',
                'content' => $options
            ],
            [
                'element' => '#bus-destination_selectpicker',
                'type'    => 'html',
                'content' => '<script type="text/javascript">$("#bus-destination").selectpicker("refresh");</script>'
            ],
        ];

        return Json::encode($response);
    }
}
