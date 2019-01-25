<?php

namespace app\modules\Codnitive\Poker\controllers;

use app\modules\Codnitive\Template\controllers\PageController;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class GameController extends PageController
{
    protected $_actions = [
        'start'  => ['get'],
        'choice' => ['get'],
        'play'   => ['get'],
        'select'   => ['get'],
    ];

    /** @inheritdoc */
    public function init()
    {
        parent::init();
        $this->setBodyClass('poker index');
        $this->setBodyId('poker_chance');
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

    /** @inheritdoc */
    public function actions()
    {
        $actions = [];
        foreach ($this->_actions as $name => $type) {
            $actions[$name] = 'app\modules\Codnitive\Poker\actions\\'.ucfirst($name).'Action';
        }
        return $actions;
    }
}
