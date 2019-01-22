<?php

namespace app\modules\Codnitive\Core\actions;

use Yii;
use yii\base\Action as BaseAction;
use yii\db\Transaction;

abstract class Action extends BaseAction
{
    protected function _getRequest()
    {
        return app()->request;
    }

    public function init () 
    {
        $request = $this->_getRequest();
        app()->language = tools()->getLanguage();
        return parent::init();
    }

    // public function beforeAction($action)
    // {
    //     $request = $this->_getRequest();
    //     app()->language = tools()->getOptionValue(
    //         'Language', 
    //         'Langi18n', 
    //         $request->get('lang', 'fa')
    //     );
    //     return parent::beforeAction($action);
    // }

    protected function beginTransaction()
    {
        return app()->db->beginTransaction(
            Transaction::SERIALIZABLE
        );
    }

    /**
     * Method to load classes with DI container
     */
    // public function getObject(string $class)
    // {
    //     $container = new \yii\di\Container;
    //     return $container->get($class);
    // }

    protected function _redirect($status = 1, $message = '')
    {
        if (!empty($message)) {
            $this->controller->setFlash($status ? 'success' : 'danger', $message);
        }
        return $this->controller->redirect($this->_redirect);
    }

    public function setFlash($type, $message)
    {
        app()->getSession()->setFlash($type, $message);
    }
}
