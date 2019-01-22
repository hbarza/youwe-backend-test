<?php

namespace app\modules\Codnitive\Insurance\actions;

use app\modules\Codnitive\Core\actions\Action;

class BuyAction extends Action
{
    public function run()
    {
        $plan = $this->_getRequest()->get();
        if (isset(app()->session->get('__virtual_cart')['insurance'])) {
            $insuranceInfo = app()->session->get('__virtual_cart')['insurance'];
            $insuranceInfo['plan_id'] = $plan['plan_code'];
            $insuranceInfo['plan_title'] = $plan['plan_title'];
            $__virtual_cart = [
                'step' => 'insurance/plans/registration',
                'insurance' => $insuranceInfo
            ];
            app()->session->set('__virtual_cart', $__virtual_cart);
        }
        return $this->controller->redirect(tools()->getUrl('insurance/plans/registration'));
    }
}
