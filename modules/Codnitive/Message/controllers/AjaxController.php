<?php

namespace app\modules\Codnitive\Message\controllers;

use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class AjaxController extends Controller
{

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['add', 'new'],
                'rules' => [
                    ['actions' => ['add', 'new'], 'allow' => true],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'add' => ['post'],
                    'new' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'add' => 'app\modules\Codnitive\Message\actions\Ajax\AddAction',
            'new' => 'app\modules\Codnitive\Message\actions\Ajax\NewAction',
        ];
    }
}
