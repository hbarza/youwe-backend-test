<?php

namespace app\modules\Codnitive\Account\controllers;

// use Yii;
use yii\web\Controller;
use dektrium\user\controllers\ProfileController as DektriumProfileController;

class ProfileController extends DektriumRecoveryController
{
    protected $_request;
    protected $_bodyClass = '';
    protected $_bodyId = '';

    public function beforeAction($action)
    {
        $this->setBodyClass('account orange');
        $this->layout = '@app/modules/Codnitive/Account/views/layouts/main';
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
