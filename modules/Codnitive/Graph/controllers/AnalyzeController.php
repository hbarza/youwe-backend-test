<?php
/**
 * Graph module main routes controller
 *
 * @author Omid Barza <hbarza@gmail.com>
 */
namespace app\modules\Codnitive\Graph\controllers;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\modules\Codnitive\Template\controllers\PageController;

class AnalyzeController extends PageController
{
    /**
     * List of available actions for this controller
     */
    protected $_actions = [
        'form'  => ['get'],
        'result'  => ['get'],
    ];

    /** @inheritdoc */
    public function init()
    {
        parent::init();
        $this->setBodyClass('graph index index-page');
        $this->setBodyId('string_analyzer');
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
            $actions[$name] = 'app\modules\Codnitive\Graph\actions\\'.ucfirst($name).'Action';
        }
        return $actions;
    }
}
