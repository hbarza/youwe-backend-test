<?php

namespace app\modules\Codnitive\SepMicro\actions;

use app\modules\Codnitive\Core\actions\Action;
use app\modules\Codnitive\SepMicro\blocks\Breadcrumbs;
// use app\modules\Codnitive\SepMicro\models\Gateway;
// use app\modules\Codnitive\SepMicro\models\RedirectForm;

class RedirectAction extends Action
{
    public function run()
    {
        if (!app()->session->has('payment_params')) {
            $this->setFlash('warning', __('template', 'Unfortunately your session has been expired, please search again.'));
            return $this->controller->redirect(tools()->getUrl());
        }

        // $gateway = $this->getObject('app\modules\Codnitive\SepMicro\models\Gateway');
        $gateway = getObject('app\modules\Codnitive\SepMicro\models\Gateway');
        $paymentParams = app()->session->get('payment_params');

        $this->controller->layout   = '@app/modules/Codnitive/Template/views/layouts/blank';
        $breadcrumbs = $this->controller->renderPartial(
            '@app/modules/Codnitive/Template/views/templates/steps/_breadcrumbs.phtml',
            ['breadcrumbs' => (new Breadcrumbs)->getBreadcrumbs('payment')]
        );

        return $this->controller->render('/templates/gateway/redirect.phtml', [
            'formModel'   => $gateway->getFormModel($paymentParams),
            'breadcrumbs' => $breadcrumbs
        ]);
    }
}
