<?php

namespace app\modules\Codnitive\SepMicro\controllers;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\modules\Codnitive\Template\controllers\PageController;

class GatewayController extends PageController
{
    protected $_actions = [
        'redirect' => ['get'],
    ];

    public function init()
    {
        parent::init();
        $this->setBodyClass('gateway');
        $this->setBodyId('sep_micro');
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
            $actions[$name] = 'app\modules\Codnitive\SepMicro\actions\\'.ucfirst($name).'Action';
        }
        return $actions;
    }
}
