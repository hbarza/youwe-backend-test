<?php

namespace app\modules\Codnitive\Bus\actions;

use app\modules\Codnitive\Core\actions\Action;
use app\modules\Codnitive\Bus\blocks\Breadcrumbs;
use app\modules\Codnitive\Bus\models\DataProvider;
use app\modules\Codnitive\Calendar\models\Gregorian;

class ResultAction extends Action
{
    public function run()
    {
        $params = tools()->stripOutInvisibles($this->_getRequest()->get());
        unset($params['lang']);

        $cartCandition = isset(app()->session->get('__virtual_cart')['step']) 
            && 'bus/process/result' == app()->session->get('__virtual_cart')['step']
            && isset(app()->session->get('__virtual_cart')['bus']);
        if (empty($params) && $cartCandition) {
            $searchParams = app()->session->get('__virtual_cart')['bus'];
            $params = [
                'path' => "{$searchParams['origin_name']}-{$searchParams['destination_name']}",
                'departing' => str_replace('/', '-', $searchParams['departing_persian'])
            ];
            return $this->controller->redirect(tools()->getUrl('bus/process/result', $params));
        }

        if (empty($params) || !isset(app()->session->get('__virtual_cart')['bus'])) {
            $this->setFlash('warning', __('template', 'Please search again'));
            return $this->controller->redirect(tools()->getUrl('', ['tab' => 'box-bus']));
        }

        if (!isset($params['s']) || !(bool) intval($params['s'])) {
            $searchParams = $this->_getSearchParams();
        }
        else {
            $searchParams = app()->session->get('__virtual_cart')['bus'];
        }

        if (isset(app()->session->get('__virtual_cart')['bus']['passenger_info'])) {
            $searchParams['passenger_info'] = app()->session->get('__virtual_cart')['bus']['passenger_info'];
        }
        $__virtual_cart = [
            'step' => 'bus/process/result',
            'bus' => $searchParams
        ];
        app()->session->set('__virtual_cart', $__virtual_cart);
        

        $breadcrumbs = $this->controller->renderPartial(
            '@app/modules/Codnitive/Template/views/templates/steps/_breadcrumbs.phtml',
            ['breadcrumbs' => (new Breadcrumbs)->getBreadcrumbs('buses')]
        );
        return $this->controller->render('/templates/search/search_result.phtml', [
            'params' => $searchParams,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    private function _getSearchParams()
    {
        $dataProvider = new DataProvider;
        $params = tools()->stripOutInvisibles($this->_getRequest()->get());
        list($originName, $destinationName) = explode('-', $params['path']);
        $origin = array_search($originName, $dataProvider->getOriginCities());
        $searchParams = [
            'origin_name' => $originName,
            'destination_name' => $destinationName,
            'departing' => (new Gregorian)->getDate($params['departing']),
            'origin' => $origin,
            'destination' => array_search($destinationName, $dataProvider->getDestinationCities($origin)),
            'departing_persian' => $params['departing']
        ];
        return $searchParams;
    }
}
