<?php

namespace app\modules\Codnitive\Bus\actions\Ajax;

use yii\helpers\Json;
use app\modules\Codnitive\Core\actions\Action;
use app\modules\Codnitive\Bus\models\DataProvider;
use app\modules\Codnitive\Bus\blocks\City;

/**
 * Method which calls with ajax to retive avaliable buses
 * 
 * @route   bus/ajax/getOrigins
 */
class GetOriginsAction extends Action
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
        $dataProvider   = new DataProvider;
        $cities         = $dataProvider->getOriginCities();
        $options        = (new City)->getSelectOptions($cities, __('bus', 'Origin'));

        $response = [
            [
                'element' => '#bus-origin',
                'type'    => 'html',
                'content' => $options
            ],
            [
                'element' => '#bus-origin_selectpicker',
                'type'    => 'html',
                'content' => '<script type="text/javascript">$("#bus-origin").selectpicker("refresh");</script>'
            ],
        ];

        return Json::encode($response);
    }
}
