<?php

namespace app\modules\Codnitive\Insurance\actions\Ajax;

use app\modules\Codnitive\Core\actions\Action;
use yii\helpers\Json;
use app\modules\Codnitive\Insurance\models\Travis;
use app\modules\Codnitive\Insurance\blocks\Plans\Confirm;

/**
 * Method which calls with ajax to register insurance policies for customer list
 * and duration of stay
 * 
 * @route   insurance/ajax/registerPolicies
 */
class RegisterPoliciesAction extends Action
{
    protected $_errorMessage = '';
    /**
     * Disbale CSRF validation because we don't have form
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
        $data = app()->session->get('__virtual_cart')['insurance'];
        $travis = new Travis;
        $allInsurances = $travis->registerAllPassengers($data);
        if (isset($allInsurances[0]) && true !== $travis->errorCheck($allInsurances[0])) {
            $this->_errorMessage = $allInsurances[0]->errorText;
            $allInsurances = [];
        }
        
        $serialNumbers = [];
        foreach ($allInsurances as $key => $incurance) {
            if (isset($incurance->bimehNo) && $incurance->bimehNo != 0) {
                $serialNumbers[$key] = $incurance->bimehNo;
            }
        }
        if (isset(app()->session->get('__virtual_cart')['insurance'])) {
            $insuranceInfo = app()->session->get('__virtual_cart')['insurance'];
            $insuranceInfo['serial_numbers']  = $serialNumbers;
            $insuranceInfo['insurances_data'] = $allInsurances;
            $__virtual_cart = [
                'step' => 'insurance/plans/confirm',
                'insurance' => $insuranceInfo
            ];
            if (!empty($allInsurances)) {
                $this->_updatePaymentSession($insuranceInfo);
            }
            app()->session->set('__virtual_cart', $__virtual_cart);
        }

        $response = [];
        if (!empty($allInsurances)) {
            $response = [
                [
                    'element' => '.ajax-result-wrapper',
                    'type'    => 'html',
                    'content' => $this->controller->renderAjax('/templates/plans/confirmation/content.phtml', [
                        'allInsurances' => $allInsurances
                    ])
                ],
                [
                    'element' => '.sidebar-payment-methods-wrapper',
                    'type'    => 'html',
                    'content' => $this->controller->renderAjax('/templates/plans/sidebar/payment.phtml', [
                        'block' => new Confirm,
                        'allInsurances' => $allInsurances
                    ])
                ]
            ];
        }
        else {
            $message = <<<MSG
                <div class="d-flex flex-row flex-lg-row flex-md-row flex-sm-row align-items-center justify-content-between flex-column p-3">
                    <div class="container alert-container my-3" style="margin-top:1rem!important;">
                        <div class="alert alert-warning"><span class="fa fa-exclamation-triangle"></span> $this->_errorMessage</div>
                    </div>
                </div>
MSG;
            $response = [
                [
                    'element' => '.ajax-result-wrapper',
                    'type'    => 'html',
                    'content' => $message
                ]
            ];
        }

        return Json::encode($response);
    }

    private function _updatePaymentSession(array $data): void
    {
        $grandTotal = (new Confirm)->getGrandTotal($data['insurances_data'], true);
        $payment_params = [
            'grand_total' => $grandTotal,
        ];
        app()->session->set('payment_params', $payment_params);
    }
}
