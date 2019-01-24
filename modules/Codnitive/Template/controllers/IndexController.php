<?php

namespace app\modules\Codnitive\Template\controllers;

use yii\helpers\Json;
use app\modules\Codnitive\Template\controllers\PageController;

class IndexController extends PageController
{

    public function actionIndex()
    {
        $this->setBodyClass('index-page');
        $this->setBodyId('index_page');
        $this->view->params['active_menu'] = Json::encode(['home']);
        return $this->render('/templates/index/home.phtml');
    }
}
