<?php

namespace app\modules\Codnitive\Bus\actions\Ajax;

use app\modules\Codnitive\Core\actions\Action;
use yii\helpers\Json;

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
        $info   = reset(app()->getModule('bus')->params['products']);
        $searchForm = new \app\modules\Codnitive\Bus\models\SearchForm;
        $response = [[
            'element' => '#tab-bus',
            'type'    => 'html',
            'content' => $this->controller->renderAjax(
                $info['template'],
                ['searchModel' => $searchForm]
            )
        ]];

        return Json::encode($response);
    }
}
