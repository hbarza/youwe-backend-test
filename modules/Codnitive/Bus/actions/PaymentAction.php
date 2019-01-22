<?php

namespace app\modules\Codnitive\Bus\actions;

use app\modules\Codnitive\Core\actions\Action;
use app\modules\Codnitive\Bus\models\DataProvider;
use app\modules\Codnitive\Sales\models\Order;
use app\modules\Codnitive\Sales\models\Order\BillingData;
use app\modules\Codnitive\Bus\models\Order\Item;

class PaymentAction extends Action
{
    public const CONFIRM_ROUTE = 'bus/process/confirm';
    public const CALLBAK_ROUTE = 'bus/process/success';

    public function run()
    {
        if (!isset(app()->session->get('__virtual_cart')['bus'])) {
            $this->setFlash('warning', __('template', 'Unfortunately your session has been expired, please search again.'));
            return $this->controller->redirect(tools()->getUrl('', ['tab' => 'box-bus']));
        }

        $requestParams = app()->getRequest()->post();
        if (!isset($requestParams['payment_method']) || empty($requestParams['payment_method'])) {
            $this->setFlash('danger', __('template', 'Please select a payment method.'));
            return $this->controller->redirect(tools()->getUrl(self::CONFIRM_ROUTE));
        }
        $paymentMethod = $requestParams['payment_method'];
        $data          = app()->session->get('__virtual_cart')['bus'];

        // @todo remove test grand total
        // $grandTotal  = 1000;
        $grandTotal    = (new DataProvider($data['reservation']['provider']))->getGrandTotal($data);
        $billingData   = new BillingData;
        $billingData->setAttributes($data['passenger_info']);
        $items         = (new Item)->getOrderItems($data);
        $order         = (new Order)->saveOrder($grandTotal, $paymentMethod, $billingData, $items);
        $gateway       = getObject("app\modules\Codnitive\\$paymentMethod\models\Gateway");
        $setupPayment  = $gateway->setupPayment(
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
