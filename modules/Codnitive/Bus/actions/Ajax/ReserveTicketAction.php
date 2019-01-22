<?php

namespace app\modules\Codnitive\Bus\actions\Ajax;

use yii\helpers\Json;
use app\modules\Codnitive\Core\actions\Action;
use app\modules\Codnitive\Bus\models\DataProvider;

/**
 * Method which calls with ajax to retive avaliable buses
 * 
 * @route   bus/ajax/searchResult
 */
class ReserveTicketAction extends Action
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
        if (isset(app()->session->get('__virtual_cart')['bus'])) {
            $reservationData = app()->session->get('__virtual_cart')['bus'];
            $bus = new DataProvider;
            $buses = $bus->getBuses($searchParams['origin'], $searchParams['destination'], $searchParams['departing']/*, $searchParams['passengers']*/);
        }

        $response = [[
            'element' => '.reserve-confirmation.ajax-result-wrapper',
            'type'    => 'html',
            'content' => $this->controller->renderAjax(
                '/templates/process/confirm/information.phtml',
                ['buses' => $buses ?? []]
            )
        ]];

        return Json::encode($response);
    }
}
