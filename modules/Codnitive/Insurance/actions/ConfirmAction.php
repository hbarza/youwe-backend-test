<?php

namespace app\modules\Codnitive\Insurance\actions;

use app\modules\Codnitive\Core\actions\Action;
use app\modules\Codnitive\Insurance\blocks\Breadcrumbs;
// use app\modules\Codnitive\Insurance\models\Travis;
use app\modules\Codnitive\Insurance\models\Insurance;
use app\modules\Codnitive\Insurance\models\Plans\Registration;

class ConfirmAction extends Action
{
    public function run()
    {
        if (!isset(app()->session->get('__virtual_cart')['insurance'])) {
            $this->setFlash('warning', __('template', 'Unfortunately your session has been expired, please search again.'));
            return $this->controller->redirect(tools()->getUrl('', ['tab' => 'box-insurance']));
        }

        $registrationInfo = $this->_getRequest()->post('insurance_registration');
        if (!empty($registrationInfo)) {
            if (!$this->_formValidate(tools()->convertFormArrayToModelArray($registrationInfo))) {
                return $this->controller->redirect(tools()->getUrl('insurance/plans/registration'));
            }

            // @todo must check for terms to be selected 
            $terms = (bool) array_pop($registrationInfo['terms']);
            $registrationInfo = (new Insurance)->uniqueRegistrationInfo(
                tools()->convertFormArrayToModelArray($registrationInfo)
            );

            $insuranceInfo = app()->session->get('__virtual_cart')['insurance'];
            $insuranceInfo['registration_info'] = $registrationInfo;
            $__virtual_cart = [
                'step' => 'insurance/plans/confirm',
                'insurance' => $insuranceInfo
            ];
            app()->session->set('__virtual_cart', $__virtual_cart);
        }
        // $this->_updatePaymentSession();

        $breadcrumbs = $this->controller->renderPartial(
            '@app/modules/Codnitive/Template/views/templates/steps/_breadcrumbs.phtml',
            ['breadcrumbs' => (new Breadcrumbs)->getBreadcrumbs('confirm')]
        );

        return $this->controller->render('/templates/plans/confirmation.phtml', [
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    private function _formValidate($registrationInfo)
    {
        $result = true;
        foreach ($registrationInfo as $index => $passenger) {
            if ($index > 0) {
                $passenger['email'] = $registrationInfo[0]['email'];
                $passenger['cellphone'] = $registrationInfo[0]['cellphone'];
                $passenger['terms'] = $registrationInfo[0]['terms'];
            }
            $registrationModel = new Registration;
            $registrationModel->setAttributes($passenger);
            if (!$registrationModel->validate()) {
                $this->setFlash('danger', $registrationModel->getErrorsFlash($registrationModel->errors));
                $result = false;
            }
        }
        return $result;
    }

    // private function _updatePaymentSession(): void
    // {
    //     $payment_params = app()->session->get('payment_params');
    //     unset($payment_params['grand_total']);
    //     app()->session->set('payment_params', $payment_params);
    // }
}
