<?php

namespace app\modules\Codnitive\Bus\controllers;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\modules\Codnitive\Account\controllers\PageController;

class AccountController extends PageController
{
    protected $_actions = [
        'ticket' => ['get'],
    ];

    // public function init()
    // {
    //     parent::init();
    //     $this->setBodyClass('account wallet orange');
    //     $this->setBodyId('wallet-account');
    // }

    /** @inheritdoc */
    public function behaviors()
    {
        $rules = [];
        $names = [];
        foreach ($this->_actions as $name => $type) {
            $rules[] = ['actions' => [$name], 'allow' => true, 'roles' => ['@']];
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
            $actions[$name] = 'app\modules\Codnitive\Bus\actions\Account\\'.ucfirst($name).'Action';
        }
        return $actions;
    }
}
