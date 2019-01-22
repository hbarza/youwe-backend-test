<?php

namespace app\modules\Codnitive\Bus\actions\Ajax;

use yii\helpers\Json;
use app\modules\Codnitive\Core\actions\Action;
use app\modules\Codnitive\Bus\models\DataProvider;
// use app\modules\Codnitive\Safar\models\Safar;

/**
 * Method which calls with ajax to retive avaliable buses
 * 
 * @route   bus/ajax/searchResult
 */
class GetBusAction extends Action
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
        $params = app()->request->get();
        $busSession = app()->session->get('__virtual_cart')['bus'];
        $busSession['selected_bus'] = $params;
        $params['search_data'] = app()->session->get('__virtual_cart')['bus'];
        $bus = (new DataProvider($params['p']))->getBus($params['id'], $params['destination'], $params);
        if (isset($bus['data_source'])) {
            $busSession['data_source'] = $bus['data_source'];
        }
        $__virtual_cart = [
            'path' => 'bus/process/result',
            'bus'  => $busSession
        ];
        app()->session->set('__virtual_cart', $__virtual_cart);

        $response = [[
            'element' => '#seat-map-'.$params['id'],
            'type'    => 'html',
            'content' => $this->controller->renderAjax(
                '/templates/search/bus/seat_map.phtml',
                ['bus' => $bus]
            )
        ]];

        return Json::encode($response);
    }
}
