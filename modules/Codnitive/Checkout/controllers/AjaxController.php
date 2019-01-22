<?php

namespace app\modules\Codnitive\Checkout\controllers;

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
                'only' => ['getPrices'],
                'rules' => [
                    ['actions' => ['getPrices'], 'allow' => true],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'getPrices' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'getPrices' => 'app\modules\Codnitive\Checkout\actions\Ajax\GetPricesAction',
        ];
    }
}
