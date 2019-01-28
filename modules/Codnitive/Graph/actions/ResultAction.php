<?php

namespace app\modules\Codnitive\Graph\actions;

use app\modules\Codnitive\Core\actions\Action;
use app\modules\Codnitive\Graph\models\Form;
use app\modules\Codnitive\Graph\models\Graph;
use app\modules\Codnitive\Graph\blocks\Result;

class ResultAction extends Action
{
    /**
     * cleans session and renders ordered cards deck
     */
    public function run()
    {
        $formModel = new Form;
        $formModel->setAttributes(app()->getRequest()->post('string_analyzer'));
        if (!$formModel->validate()) {
            $this->setFlash('danger', $formModel->getErrorsFlash($formModel->errors));
            return $this->controller->redirect(tools()->getUrl('graph/analyze/form'));
        }
        
        $string = app()->getRequest()->post('string_analyzer')['string'];
        $graph  = (new Graph(strtolower($string)))->analyze();
        $graph->traverse();

        return $this->controller->render('/templates/result.phtml', [
            'string'     => $string,
            'statistics' => $graph->getStatistics(),
            'graph'      => (new Result)->drawGraph($graph->getStatistics(false))
        ]);
    }
}
