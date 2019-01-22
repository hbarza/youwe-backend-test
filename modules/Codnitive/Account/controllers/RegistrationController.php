<?php

namespace app\modules\Codnitive\Account\controllers;

// use Yii;
use yii\web\Controller;
use dektrium\user\controllers\RegistrationController as DektriumRegistrationController;

class RegistrationController extends DektriumRegistrationController
{
    protected $_request;
    protected $_bodyClass = '';
    protected $_bodyId = '';

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
