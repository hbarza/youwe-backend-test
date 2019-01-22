<?php

namespace app\modules\Codnitive\Account\controllers;

use app\modules\Codnitive\Account\controllers\PageController;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
// use dektrium\user\filters\AccessRule;
// use app\modules\Codnitive\Account\actions\Index;

class IndexController extends PageController
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
                'only' => ['index', 'information', 'update'],
                'rules' => [
                    ['actions' => ['index'], 'allow' => true, 'roles' => ['@']],
                    ['actions' => ['information'], 'allow' => true, 'roles' => ['@']],
                    ['actions' => ['update'], 'allow' => true, 'roles' => ['@']],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    // 'index' => ['post'],
                    'update' => ['post'],
                ],
            ],
        ];
    }

    // public function actionIndex()
    // {
    //     return $this->render('/account/dashboard');
    // }

    public function actions()
    {
        return [
            'index' => 'app\modules\Codnitive\Account\actions\IndexAction',
            'information' => 'app\modules\Codnitive\Account\actions\InformationAction',
            // 'update' => 'app\modules\Codnitive\Account\actions\UpdateAction',
        ];
    }
}
