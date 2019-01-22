<?php

namespace app\modules\Codnitive\Bus\actions;

use app\modules\Codnitive\Core\actions\Action;
use app\modules\Codnitive\Bus\blocks\Breadcrumbs;
use app\modules\Codnitive\Sales\models\Order;
use app\modules\Codnitive\Bus\models\DataProvider;
// use app\modules\Codnitive\Sales\models\Order\Item\TicketData;
use app\modules\Codnitive\Bus\models\Order\TicketPrintData;

class SuccessAction extends Action
{
    private $_params;
    private $_sessionData;
    private $_dataProvider;
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
            return $this->controller->redirect(tools()->getUrl('', ['tab' => 'box-bus']));
        }
        if (!isset(app()->session->get('__virtual_cart')['bus'])/* || empty(array_filter($this->_params))*/) {
            $this->setFlash('warning', __('template', 'Unfortunately your session has been expired, please search again.'));
            return $this->controller->redirect(tools()->getUrl('', ['tab' => 'box-bus']));
        }
        $this->_params = $this->_getRequest()->isPost
            ? $this->_getRequest()->post()
            : $this->_getRequest()->get();
        // app()->getModule('bus');
        $this->_sessionData = app()->session->get('__virtual_cart')['bus'];

        $gateway = $this->_processPayment();
        if (!$gateway) {
            return $this->controller->redirect(tools()->getUrl('bus/process/confirm'));
        }
        $this->_order   = (new Order)->loadOne($this->_params['ResNum'])->setSuccessPayment(
            $gateway->getPaymentInfo($this->_params)
        );

        $bookingStatus = $this->_processBooking();
        if ($bookingStatus['ticket_number'] === false && 'revert' == $bookingStatus['action']) {
            return $this->_revertAction($gateway, $bookingStatus);
        }
        else if ($bookingStatus['ticket_number'] === false && 'continue' == $bookingStatus['action']) {
            $this->setFlash('info', $bookingStatus['message']);
            $paymentTraceNumber = $this->_order->payment_info->trace_number 
                ?? $this->_order->payment_info['trace_number'];
            $ticketPrintData = [
                'order_number' => $this->_order->getOrderNumber(), 
                'payment_trace_number' => $paymentTraceNumber,
                'continue_action' => true
            ];
        }
        else if ($bookingStatus['ticket_number'] !== false && 'success' == $bookingStatus['action']) {
            $ticketPrintData = $this->_successAction($bookingStatus);
        }

        app()->session->remove('__virtual_cart');
        app()->session->remove('payment_params');
        app()->session->set('success_checkout', true);
        $breadcrumbs = $this->controller->renderPartial(
            '@app/modules/Codnitive/Template/views/templates/steps/_breadcrumbs.phtml',
            ['breadcrumbs' => (new Breadcrumbs)->getBreadcrumbs('success')]
        );
        return $this->controller->render('/templates/process/success.phtml', [
            'breadcrumbs' => $breadcrumbs,
            'ticket' => $ticketPrintData ?? [],
            // 'order' => (new Order)->loadOne($this->_order->id)
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

    private function _processBooking(): array
    {
        $provider       = $this->_sessionData['reservation']['provider'];
        $this->_dataProvider   = new DataProvider($provider);
        return $this->_dataProvider->bookTicket($this->_sessionData);
    }

    private function _revertAction($gateway, array $bookingStatus)
    {
        $revertTransaction = $gateway->revertTransaction($this->_params['RefNum'], $this->_order->getOrderNumber());
        $this->setFlash('success', $revertTransaction['message']);
        $this->setFlash('danger', $bookingStatus['message']);
        app()->session->remove('payment_params');
        unset(
            $this->_sessionData['data_source'], 
            $this->_sessionData['reservation']
        );
        $__virtual_cart = [
            'bus' => $this->_sessionData
        ];
        app()->session->set('__virtual_cart', $__virtual_cart);
        $this->_order->setOrderCancel()->save();
        return $this->controller->redirect(tools()->getUrl('bus/process/result'));
    }

    private function _successAction(array $bookingStatus): TicketPrintData
    {
        $ticketInfo = $this->_dataProvider->getTicket($bookingStatus['ticket_number'], $this->_sessionData);
        $ticketInfo['ticket_id'] = $bookingStatus['ticket_number'];
        
        $updateOrderStatus = $this->_order->saveTicketItemsData(
            $this->_dataProvider->getOrderItemTicketData($this->_order, $ticketInfo)
        );
        $this->_order->save();

        !$updateOrderStatus 
            ? $this->setFlash('warning', __('bus', 'We couldn\'t update order to save ticket data, please save or print this information.'))
            : $this->setFlash('success', $bookingStatus['message']);
        return $this->_dataProvider->getTicketPrintData($ticketInfo, $this->_order);
    }
}
