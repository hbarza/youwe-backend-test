<?php

namespace app\modules\Codnitive\Template\controllers;

use yii\web\Controller;

class PageController extends Controller
{
    protected $_request;

    protected $_bodyClass = '';
    protected $_bodyId = '';

    protected $_headerBottom = '';

    // public $activeMenu = '';

    public function beforeAction($action)
    {
        $this->_request = app()->request;
        app()->language = tools()->getLanguage();
        $this->layout   = '@app/modules/Codnitive/Template/views/layouts/main';
        unset($this->view->params['active_menu']);
        return parent::beforeAction($action);
    }

    public function setFlash(string $type, string $message): self
    {
        app()->getSession()->setFlash($type, $message);
        return $this;
    }

    public function setBodyClass(string $bodyClass): self
    {
        $this->_bodyClass = $bodyClass;
        return $this;
    }

    public function getBodyClass(): string
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

    public function renderHeaderBottom(): string
    {
        return $this->_headerBottom ? $this->renderPartial($this->_headerBottom) : '';
    }

    public function setHeaderBottom(string $templatePath): self
    {
        $this->_headerBottom = $templatePath;
        return $this;
    }
}
