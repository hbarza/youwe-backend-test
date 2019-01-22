<?php

namespace app\modules\Codnitive\Bus\controllers;

use app\modules\Codnitive\Template\controllers\PageController;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class ProcessController extends PageController
{
    protected $_actions = [
        'search' => ['get'],
        'result' => ['get'],
        'saveSeats' => ['get'],
        'registration' => ['post', 'get'],
        'confirm' => ['post', 'get'],
        'payment' => ['post'],
        'success' => ['post', 'get'],
    ];

    public function init()
    {
        parent::init();
        $this->setBodyClass('bus search-result pink');
        $this->setBodyId('bus');
        // $this->setHeaderBottom('@app/modules/Codnitive/Template/views/index/home/slider.phtml');
    }

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
            $actions[$name] = 'app\modules\Codnitive\Bus\actions\\'.ucfirst($name).'Action';
        }
        return $actions;
    }
}
