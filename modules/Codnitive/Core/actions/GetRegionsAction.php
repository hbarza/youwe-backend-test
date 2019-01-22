<?php

namespace app\modules\Codnitive\Core\actions;

use yii\base\Action;

class GetRegionsAction extends Action
{
    public function run()
    {
        $countryCode = app()->request->post('country_code');
        $formName = app()->request->post('form_name');
        return $this->controller->renderPartial(
            '/html/country/region',
            ['countryCode' => $countryCode, 'formName' => $formName]
        );
    }
}
