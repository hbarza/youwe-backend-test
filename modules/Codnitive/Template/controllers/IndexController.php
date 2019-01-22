<?php

namespace app\modules\Codnitive\Template\controllers;

use yii\helpers\Json;
use app\modules\Codnitive\Template\controllers\PageController;
// use app\modules\Codnitive\Core\Module as CoreModule;

class IndexController extends PageController
{
    // private $modulesList = [
    //     'insurance',
    //     'bus'
    // ];

    public function actionIndex()
    {
        // CoreModule::loadModules($this->modulesList);
        // $this->loadModules();
        
        // return $this->render('@app/modules/Codnitive/Template/views/layouts/index/home');
        // $this->view->params['customParam'] = 'customValue';
        // \Yii::$app->view->params['customParam'] = 'customValue';
        $this->setBodyClass('homepage');
        $this->setBodyId('homepage');
        $this->view->params['active_menu'] = Json::encode(['home']);
        $this->setHeaderBottom('home/slider.phtml');
        return $this->render('home.phtml');
    }

    // private function loadModules()
    // {
    //     foreach ($this->modulesList as $module) {
    //         app()->getModule($module);
    //     }
    // }
}
