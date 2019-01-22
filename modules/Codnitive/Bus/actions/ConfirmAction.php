<?php

namespace app\modules\Codnitive\Bus\actions;

use app\modules\Codnitive\Core\actions\Action;
use app\modules\Codnitive\Bus\blocks\Breadcrumbs;
use app\modules\Codnitive\Bus\models\Process\Registration;
use app\modules\Codnitive\Bus\blocks\Process\Confirm;

class ConfirmAction extends Action
{
    public function run()
    {
        if (!isset(app()->session->get('__virtual_cart')['bus'])) {
            $this->setFlash('warning', __('template', 'Unfortunately your session has been expired, please search again.'));
            return $this->controller->redirect(tools()->getUrl('', ['tab' => 'box-bus']));
        }

        $passengerInfo = $this->_getRequest()->post('bus_registration');
        if (!empty($passengerInfo)) {
            $registrationModel = new Registration;
            $registrationModel->setAttributes($passengerInfo);
            if (!$registrationModel->validate()) {
                $this->setFlash('danger', $registrationModel->getErrorsFlash($registrationModel->errors));
                return $this->controller->redirect(tools()->getUrl('bus/process/registration'));
            }

            $bus = app()->session->get('__virtual_cart')['bus'];
            $bus['passenger_info'] = $passengerInfo;
            $this->_updatePaymentSession($bus);
            $__virtual_cart = [
                'step' => 'bus/process/confirm',
                'bus' => $bus
            ];
            app()->session->set('__virtual_cart', $__virtual_cart);
        }
        
        $breadcrumbs = $this->controller->renderPartial(
            '@app/modules/Codnitive/Template/views/templates/steps/_breadcrumbs.phtml',
            ['breadcrumbs' => (new Breadcrumbs)->getBreadcrumbs('confirm')]
        );
        return $this->controller->render('/templates/process/confirm.phtml', [
            'breadcrumbs' => $breadcrumbs,
            'data' => app()->session->get('__virtual_cart')['bus']
        ]);
    }

    private function _updatePaymentSession(array $data): void
    {
        $grandTotal = (new Confirm($data))->getGrandTotal(true);
        $payment_params = [
            'grand_total' => $grandTotal,
        ];
        app()->session->set('payment_params', $payment_params);
    }
}
