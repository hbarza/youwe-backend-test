<?php

namespace app\modules\Codnitive\Insurance\actions;

use app\modules\Codnitive\Core\actions\Action;
use app\modules\Codnitive\Insurance\blocks\Breadcrumbs;
use app\modules\Codnitive\Insurance\models\Travis;
use app\modules\Codnitive\Sales\models\Order;
use app\modules\Codnitive\Insurance\models\Order\Item;
use app\modules\Codnitive\Insurance\models\Insurance;

class PaymentAction extends Action
{
    public const CONFIRM_ROUTE = 'insurance/plans/confirm';
    public const CALLBAK_ROUTE = 'insurance/plans/success';

    private $_sessionData;

    public function run()
    {
        if (!isset(app()->session->get('__virtual_cart')['insurance'])) {
            $this->setFlash('warning', __('template', 'Unfortunately your session has been expired, please search again.'));
            return $this->controller->redirect(tools()->getUrl('', ['tab' => 'box-insurance']));
        }

        $requestParams = app()->getRequest()->post();
        if (!isset($requestParams['payment_method']) || empty($requestParams['payment_method'])) {
            $this->setFlash('danger', __('template', 'Please select a payment method.'));
            return $this->controller->redirect(tools()->getUrl(self::CONFIRM_ROUTE));
        }
        $paymentMethod      = $requestParams['payment_method'];
        $gateway            = getObject("app\modules\Codnitive\\$paymentMethod\models\Gateway");
        $this->_sessionData = app()->session->get('__virtual_cart')['insurance'];

        $insurance = new Insurance;
        // @todo remove test grand total
        // $grandTotal  = 1000;
        $grandTotal   = $insurance->getGrandTotal($this->_sessionData['insurances_data']);
        $billingData  = $insurance->getBillingData($this->_sessionData['registration_info']);
        $items        = (new Item)->getOrderItems($this->_sessionData['insurances_data']);
        $order        = (new Order)->saveOrder($grandTotal, $paymentMethod, $billingData, $items);
        $setupPayment = $gateway->setupPayment(
            $order, 
            $requestParams, 
            self::CALLBAK_ROUTE
        );

        if ($setupPayment['status'] && !empty($setupPayment['redirect'])) {
            return $this->controller->redirect($setupPayment['redirect']);
        }
        $this->setFlash('warning', __('template', $setupPayment['message']));
        return $this->controller->redirect(tools()->getUrl(self::CONFIRM_ROUTE));
    }
}
