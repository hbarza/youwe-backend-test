<?php

namespace app\modules\Codnitive\Insurance\actions\Ajax;

use yii\helpers\Json;
use app\modules\Codnitive\Core\actions\Action;
use app\modules\Codnitive\Insurance\blocks\SearchForm;

/**
 * Method which calls with ajax to retive avaliable countries
 * 
 * @route   insurance/ajax/getCountries
 */
class GetCountriesAction extends Action
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
        $options        = (new SearchForm)->getCountriesOptions();

        $response = [
            [
                'element' => '#insurance-country',
                'type'    => 'html',
                'content' => $options
            ],
            [
                'element' => '#insurance-country_selectpicker',
                'type'    => 'html',
                'content' => '<script type="text/javascript">$("#insurance-country").selectpicker("refresh");</script>'
            ],
        ];

        return Json::encode($response);
    }
}
