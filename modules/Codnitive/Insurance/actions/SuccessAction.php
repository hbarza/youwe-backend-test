<?php

namespace app\modules\Codnitive\Insurance\actions;

use app\modules\Codnitive\Core\actions\Action;
use app\modules\Codnitive\Insurance\blocks\Breadcrumbs;
use app\modules\Codnitive\Insurance\models\Travis;
use app\modules\Codnitive\Sales\models\Order;
use app\modules\Codnitive\Insurance\models\Insurance;

class SuccessAction extends Action
{
    private $_params;
    private $_sessionData;
    private $_order;

    /**
     * Disbale CSRF validation for loading search form
     */
    public function init()
    {
        parent::init();
        app()->controller->enableCsrfValidation = false;    
    }

    public function run()
    {
        if (app()->session->has('success_checkout') && app()->session->get('success_checkout')) {
            $this->setFlash('warning', __('template', 'This order was finished successfully, please search again.'));
            return $this->controller->redirect(tools()->getUrl('', ['tab' => 'box-insurance']));
        }
        
        $sessionExpiered = !isset(app()->session->get('__virtual_cart')['insurance']) 
            || !isset(app()->session->get('__virtual_cart')['insurance']['serial_numbers'])
            /*|| empty(array_filter($this->_params))*/;
        if ($sessionExpiered) {
            $this->setFlash('warning', __('insurance', 'Unfortunately your session has been expired, please search again.'));
            return $this->controller->redirect(tools()->getUrl('', ['tab' => 'box-insurance']));
        }
        $this->_params = $this->_getRequest()->isPost
            ? $this->_getRequest()->post()
            : $this->_getRequest()->get();
        $this->_sessionData = app()->session->get('__virtual_cart')['insurance'];

        $gateway = $this->_processPayment();
        if (!$gateway) {
            return $this->controller->redirect(tools()->getUrl('insurance/plans/confirm'));
        }
        $this->_order   = (new Order)->loadOne($this->_params['ResNum'])->setSuccessPayment(
            $gateway->getPaymentInfo($this->_params)
        );

        $travis     = new Travis;
        $insurances = $travis->confirmPolicies($this->_sessionData['serial_numbers']);
        if (isset($insurances[0]) && true !== $travis->errorCheck($insurances[0])) {
            $insurances = $this->_revertAction($gateway, $insurances[0]->errorText);
        }
        else {
            $this->_successAction($insurances);
        }

        app()->session->remove('__virtual_cart');
        app()->session->remove('payment_params');
        app()->session->set('success_checkout', true);
        $breadcrumbs = $this->controller->renderPartial(
            '@app/modules/Codnitive/Template/views/templates/steps/_breadcrumbs.phtml',
            ['breadcrumbs' => (new Breadcrumbs)->getBreadcrumbs('success')]
        );
        return $this->controller->render('/templates/plans/success.phtml', [
            'insurances'  => $insurances,
            'breadcrumbs' => $breadcrumbs,
            'order' => $this->_order
        ]);
    }

    private function _processPayment()
    {
        $paymentMethod = app()->session->get('payment_params')['payment_method'];
        app()->getModule(strtolower($paymentMethod));
        $gateway = getObject("app\modules\Codnitive\\$paymentMethod\models\Gateway");
        $verificationResult = $gateway->finalizeTransaction($this->_params);

        if (!isset($verificationResult['status']) || !$verificationResult['status']) {
            $this->setFlash('warning', $verificationResult['message']);
            return false;
        }
        return $gateway;
    }

    private function _revertAction($gateway, string $error): bool
    {
        $revertTransaction = $gateway->revertTransaction($this->_params['RefNum'], $this->_order->getOrderNumber());
        $this->setFlash('success', $revertTransaction['message']);
        $this->setFlash('danger', $error);
        app()->session->remove('payment_params');
        unset(
            $this->_sessionData['insurances_data'], 
            $this->_sessionData['serial_numbers'], 
            $this->_sessionData['registration_info']
        );
        $__virtual_cart = [
            'insurance' => $this->_sessionData
        ];
        app()->session->set('__virtual_cart', $__virtual_cart);
        $this->_order->setOrderCancel()->save();
        return false;
        // return $this->controller->redirect(tools()->getUrl('insurance/plans/result'));
    }

    private function _successAction(array $insurances): void
    {
        $updateOrderStatus = $this->_order->saveTicketItemsData(
            (new Insurance)->getOrderItemsTicketData($this->_order, $insurances)
        );
        $this->_order->save();

        !$updateOrderStatus 
            ? $this->setFlash('warning', __('template', 'We couldn\'t update order to save ticket data, please save or print this information.'))
            : $this->setFlash('success',  __('insurance', 'Your insurance(s) was issued successfully.'));
    }
}
