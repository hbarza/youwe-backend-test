<?php

namespace app\modules\Codnitive\Insurance\actions;

use app\modules\Codnitive\Core\actions\Action;
use app\modules\Codnitive\Insurance\blocks\Breadcrumbs;
use app\modules\Codnitive\Insurance\models\Plans\Registration;

class RegistrationAction extends Action
{
    public function run()
    {
        if (!isset(app()->session->get('__virtual_cart')['insurance'])) {
            $this->setFlash('warning', __('template', 'Unfortunately your session has been expired, please search again.'));
            return $this->controller->redirect(tools()->getUrl('', ['tab' => 'box-insurance']));
        }

        $breadcrumbs = $this->controller->renderPartial(
            '@app/modules/Codnitive/Template/views/templates/steps/_breadcrumbs.phtml',
            ['breadcrumbs' => (new Breadcrumbs)->getBreadcrumbs('info')]
        );
        return $this->controller->render('/templates/plans/registration.phtml', [
            'breadcrumbs'   => $breadcrumbs,
            'emptyModel'    => (new Registration),
            'model'         => $this->_getFormModel(),
            'passengers'    => app()->session->get('__virtual_cart')['insurance']['registration_info'] ?? []
        ]);
    }

    private function _getFormModel()
    {
        $model = new Registration;
        if (isset(app()->session->get('__virtual_cart')['insurance']['registration_info'][0])) {
            $model->setAttributes(app()->session->get('__virtual_cart')['insurance']['registration_info'][0]);
        }
        $model->removed = 0;
        return $model;
    }
}
