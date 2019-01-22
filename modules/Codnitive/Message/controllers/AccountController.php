<?php

namespace app\modules\Codnitive\Message\controllers;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\modules\Codnitive\Account\controllers\PageController;

class AccountController extends PageController
{
    protected $_actionNames = [
        'list', 'view'
    ];

    public function init()
    {
        parent::init();
        $this->setBodyClass('account messages orange');
    }

    /** @inheritdoc */
    public function behaviors()
    {
        $rules = [];
        foreach ($this->_actionNames as $name) {
            $rules[] = ['actions' => [$name], 'allow' => true, 'roles' => ['@']];
        }

        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => $this->_actionNames,
                'rules' => $rules,
            ],
            // 'verbs' => [
            //     'class' => VerbFilter::className(),
            //     'actions' => [
            //         // 'index' => ['post'],
            //         'update' => ['post'],
            //     ],
            // ],
        ];
    }

    public function actions()
    {
        $actions = [];
        foreach ($this->_actionNames as $name) {
            $actions[$name] = 'app\modules\Codnitive\Message\actions\Account\\'.ucfirst($name).'Action';
        }
        return $actions;
    }
}
