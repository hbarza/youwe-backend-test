<?php

namespace app\modules\Codnitive\Bus\actions;

use app\modules\Codnitive\Core\actions\Action;
use app\modules\Codnitive\Bus\models\SearchForm;

class SearchAction extends Action
{
    public function run()
    {
        $params = [];
        app()->session->remove('success_checkout');
        app()->session->remove('__virtual_cart');
        $searchParams = tools()->stripOutInvisibles($this->_getRequest()->get('bus'));
        if (!empty($searchParams)) {
            $searchForm = new SearchForm;
            $searchForm->setAttributes($searchParams);
            if (!$searchForm->validate()) {
                $this->setFlash('danger', $searchForm->getErrorsFlash($searchForm->errors));
                return $this->controller->redirect(tools()->getUrl('', ['tab' => 'box-bus']));
            }
            
            $__virtual_cart = ['bus' => $searchParams];
            app()->session->set('__virtual_cart', $__virtual_cart);
            $params = [
                'path' => "{$searchParams['origin_name']}-{$searchParams['destination_name']}",
                'departing' => str_replace('/', '-', $searchParams['departing_persian']),
                's' => true
            ];
        }
        return $this->controller->redirect(tools()->getUrl('bus/process/result', $params));
    }
}
