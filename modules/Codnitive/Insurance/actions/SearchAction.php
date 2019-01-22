<?php

namespace app\modules\Codnitive\Insurance\actions;

use app\modules\Codnitive\Core\actions\Action;
use app\modules\Codnitive\Insurance\models\SearchForm;

class SearchAction extends Action
{
    public function run()
    {
        $params = [];
        app()->session->remove('success_checkout');
        app()->session->remove('__virtual_cart');
        $searchParams = tools()->stripOutInvisibles($this->_getRequest()->get('insurance'));
        if (!empty($searchParams)) {
            $searchForm = new SearchForm;
            $searchForm->setAttributes($searchParams);
            if (!$searchForm->validate()) {
                $this->setFlash('danger', $searchForm->getErrorsFlash($searchForm->errors));
                return $this->controller->redirect(tools()->getUrl('', ['tab' => 'box-insurance']));
            }
            
            $__virtual_cart = ['insurance' => $searchParams];
            app()->session->set('__virtual_cart', $__virtual_cart);
            $params = [
                'insurance' => "{$searchParams['country_name']}-{$searchParams['duration']}".__('insurance', 'days'),
                'cid' => $searchParams['country'],
                's' => true
            ];
        }
        return $this->controller->redirect(tools()->getUrl('insurance/plans', $params));
    }
}
