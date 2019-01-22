<?php

namespace app\modules\Codnitive\Insurance\controllers;

use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class AjaxController extends Controller
{
    protected $_actions = [
        'searchForm' => ['post'],
        'getCustomer' => ['post'],
        'registerPolicies' => ['post'],
        'getCountries' => ['post'],
        'getDurations' => ['post'],
    ];

    /** @inheritdoc */
    public function behaviors()
    {
        $rules = [];
        $names = [];
        foreach ($this->_actions as $name => $type) {
            $rules[] = ['actions' => [$name], 'allow' => true];
            $names[] = $name;
        }

        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => $names,
                'rules' => $rules,
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => $this->_actions,
            ],
        ];
    }

    public function actions()
    {
        $actions = [];
        foreach ($this->_actions as $name => $type) {
            $actions[$name] = 'app\modules\Codnitive\Insurance\actions\Ajax\\'.ucfirst($name).'Action';
        }
        return $actions;
    }

}
