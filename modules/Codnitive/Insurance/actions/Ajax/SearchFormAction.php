<?php

namespace app\modules\Codnitive\Insurance\actions\Ajax;

// use Yii;
// use yii\base\Action;
use app\modules\Codnitive\Core\actions\Action;
use yii\helpers\Json;
use app\modules\Codnitive\Insurance\models\Travis;
use app\modules\Codnitive\Core\helpers\Tools;

/**
 * Method which calls with ajax to retive avaliable plans for selected country
 * and duration of stay
 * 
 * @route   insurance/ajax/searchForm
 */
class SearchFormAction extends Action
{
    /**
     * Disbale CSRF validation for loading search form
     */
    public function init()
    {
        parent::init();
        app()->controller->enableCsrfValidation = false;    
    }

    /**
     * get request form params and retrives available plans, then generates 
     * block template and return response
     */
    public function run()
    {
        $info   = reset(app()->getModule('insurance')->params['products']);
        // $params = app()->request->post();
        $searchForm = new \app\modules\Codnitive\Insurance\models\SearchForm;
        $response = [[
            'element' => '#tab-insurance',
            'type'    => 'html',
            // 'content' => $this->controller->renderPartial(
            'content' => $this->controller->renderAjax(
                $info['template'],
                ['searchModel' => $searchForm]
            )
        ]];

        return Json::encode($response);
    }
}
