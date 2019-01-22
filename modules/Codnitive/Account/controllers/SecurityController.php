<?php

namespace app\modules\Codnitive\Account\controllers;

// use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use dektrium\user\controllers\SecurityController as DektriumSecurityController;

class SecurityController extends DektriumSecurityController
{
    protected $_request;
    protected $_bodyClass = '';
    protected $_bodyId = '';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['allow' => true, 'actions' => ['login', 'auth'], 'roles' => ['?']],
                    ['allow' => true, 'actions' => ['login', 'auth', 'logout'], 'roles' => ['@']],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => [/*'post', */'get'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        $this->layout = '@app/modules/Codnitive/Template/views/layouts/main';
        $this->_request = app()->request;
        return parent::beforeAction($action);
    }

    public function setBodyClass($bodyClass)
    {
        $this->_bodyClass = $bodyClass;
        return $this;
    }

    public function getBodyClass()
    {
        return $this->_bodyClass;
    }

    public function setBodyId(string $bodyId): self
    {
        $this->_bodyId = $bodyId;
        return $this;
    }

    public function getBodyId(): string
    {
        return $this->_bodyId;
    }

}
