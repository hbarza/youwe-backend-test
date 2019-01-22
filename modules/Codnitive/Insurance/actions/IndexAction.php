<?php

namespace app\modules\Codnitive\Insurance\actions;

use Yii;
// use yii\base\Action;
use app\modules\Codnitive\Core\actions\Action;
use app\modules\Codnitive\Insurance\models\Travis;
use app\modules\Codnitive\Insurance\blocks\Breadcrumbs;
use app\modules\Codnitive\Insurance\blocks\SearchForm;

class IndexAction extends Action
{
    public function run()
    {
        $params = tools()->stripOutInvisibles($this->_getRequest()->get());
        unset($params['lang']);
        $cartCandition = isset(app()->session->get('__virtual_cart')['step']) 
            && 'insurance/plans' == app()->session->get('__virtual_cart')['step']
            && isset(app()->session->get('__virtual_cart')['insurance']);
        if (empty($params) && $cartCandition) {
            $searchParams = app()->session->get('__virtual_cart')['insurance'];
            $params = [
                'insurance' => "{$searchParams['country_name']}-{$searchParams['duration']}".__('insurance', 'days'),
                'cid' => $searchParams['country']
            ];
            return $this->controller->redirect(tools()->getUrl('insurance/plans', $params));
        }
        if (empty($params) || !isset(app()->session->get('__virtual_cart')['insurance'])) {
            $this->setFlash('warning', __('template', 'Please search again'));
            return $this->controller->redirect(tools()->getUrl('', ['tab' => 'box-insurance']));
        }

        if (!isset($params['s']) || !(bool) intval($params['s'])) {
            $searchParams = $this->_getSearchParams();
        }
        else {
            $searchParams = app()->session->get('__virtual_cart')['insurance'];
        }

        if (isset(app()->session->get('__virtual_cart')['insurance']['registration_info'])) {
            $searchParams['registration_info'] = app()->session->get('__virtual_cart')['insurance']['registration_info'];
        }
        $__virtual_cart = [
            'step' => 'insurance/plans',
            'insurance' => $searchParams
        ];
        app()->session->set('__virtual_cart', $__virtual_cart);

        $travis = new Travis;
        $plans  = $travis->getPlansWithDetail(
            $searchParams['country'],
            $searchParams['duration'],
            $searchParams['age']
            // $searchParams['birthday']
        );
        if (isset($plans[0]) && true !== $travis->errorCheck($plans[0])) {
            $this->setFlash('warning', $plans[0]->errorText);
            // $plans = false;
            $plans = [];
        }
        $breadcrumbs = $this->controller->renderPartial(
            '@app/modules/Codnitive/Template/views/templates/steps/_breadcrumbs.phtml',
            ['breadcrumbs' => (new Breadcrumbs)->getBreadcrumbs('plans')]
        );
        return $this->controller->render('/templates/plans/results.phtml', [
            'plans'  => $plans,
            'params' => $searchParams,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    private function _getSearchParams()
    {
        $params = tools()->stripOutInvisibles($this->_getRequest()->get());
        list($countryName, $duraction) = explode('-', $params['insurance']);
        return [
            'country_name' => $countryName,
            'country' => $params['cid'],
            'duration' => intval($duraction),
            'age' => '35'
        ];
    }
}
