<?php

namespace app\modules\Codnitive\Bus\actions;

use app\modules\Codnitive\Core\actions\Action;

class SaveSeatsAction extends Action
{
    public function run()
    {
        $reservationParams = $this->_getRequest()->get('busSeat');
        if (!isset(app()->session->get('__virtual_cart')['bus'])) {
            $this->setFlash('warning', __('template', 'Unfortunately your session has been expired, please search again.'));
            return $this->controller->redirect(tools()->getUrl('', ['tab' => 'box-bus']));
        }
        if (!empty($reservationParams)) {
            $bus = app()->session->get('__virtual_cart')['bus'];
            $bus['reservation'] = $reservationParams;
            $__virtual_cart = [
                'step' => 'bus/process/registration',
                'bus' => $bus
            ];
            app()->session->set('__virtual_cart', $__virtual_cart);
        }
        return $this->controller->redirect(tools()->getUrl('bus/process/registration'));
    }
}
