<?php

namespace app\modules\Codnitive\Core\controllers;

// use app\modules\Codnitive\Template\controllers\PageController;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
// use dektrium\user\filters\AccessRule;
// use app\modules\Codnitive\Account\actions\Index;

class AjaxController extends Controller
{
    /*public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }*/

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['getregions'],
                'rules' => [
                    ['actions' => ['getregions'], 'allow' => true, 'roles' => ['?', '@']],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'getregions' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'getregions' => 'app\modules\Codnitive\Core\actions\GetRegionsAction',
        ];
    }
}
