<?php

namespace app\modules\Codnitive\Bus\actions;

use yii\helpers\ArrayHelper;
use app\modules\Codnitive\Core\actions\Action;
use app\modules\Codnitive\Bus\blocks\Breadcrumbs;
use app\modules\Codnitive\Bus\models\Process\Registration;

class RegistrationAction extends Action
{
    public function run()
    {
        // var_dump(app()->session->get('__virtual_cart'));
        // exit;
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
        
        $breadcrumbs = $this->controller->renderPartial(
            '@app/modules/Codnitive/Template/views/templates/steps/_breadcrumbs.phtml',
            ['breadcrumbs' => (new Breadcrumbs)->getBreadcrumbs('info')]
        );
        return $this->controller->render('/templates/process/registration.phtml', [
            'breadcrumbs' => $breadcrumbs,
            'model'       => $this->_getFormModel(),
            'passengersCount' => count(explode(',', app()->session->get('__virtual_cart')['bus']['reservation']['seat_numbers'])),
            'bus' => app()->session->get('__virtual_cart')['bus']
        ]);
    }

    private function _getFormModel()
    {
        $info  = [];
        $model = new Registration;
        $busData = app()->session->get('__virtual_cart')['bus'];
        if (isset($busData['passenger_info'])) {
            $info = $busData['passenger_info'];
            unset($info['terms']);
        }
        else if (!tools()->isGuest()) {
            $info = ArrayHelper::merge(
                tools()->getUser()->identity->getAttributes(), 
                tools()->getUserNameParts()
            );
        }
        $model->setAttributes($info);
        return $model;
    }
}
