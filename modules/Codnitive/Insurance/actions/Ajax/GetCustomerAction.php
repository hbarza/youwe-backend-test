<?php

namespace app\modules\Codnitive\Insurance\actions\Ajax;

// use Yii;
// use yii\base\Action;
use app\modules\Codnitive\Core\actions\Action;
use yii\helpers\Json;
use app\modules\Codnitive\Insurance\models\Travis;

/**
 * Method which calls with ajax to retive avaliable plans for selected country
 * and duration of stay
 * 
 * @route   insurance/ajax/searchForm
 */
class GetCustomerAction extends Action
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
        $nationalId = app()->request->post('national_id');
        $customer = (array) (new Travis)->getCustomer($nationalId);
        $customer['birthDate'] = (new \DateTime($customer['birthDate']))->format('Y-m-d');
        $response = [
            'customer' => $customer
        ];

        return Json::encode($response);
    }
}
