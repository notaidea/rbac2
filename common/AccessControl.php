<?php
namespace common;

use Yii;
use yii\base\Component;
use yii\base\Module;
use yii\web\ForbiddenHttpException;
use common\models\AccessMenu;

class AccessControl extends \yii\base\ActionFilter
{
    public $freeUrls = [];
    public $freeControllers = [];
    protected $_isFree = false;
    protected $_action;

    public function beforeAction($action)
    {
        $parent = parent::beforeAction($action);
        $this->_action = $action;
        $this->_isFree = $this->freeHandler();

        if ($this->_isFree == true) {
            return true;
        }

        $this->guestRedirect();
        $this->checkAuth();

        return $parent;
    }

    //todo 写一个通配符匹配，如site/*
    protected function freeHandler()
    {
        //$url
        $url = $this->_action->controller->module->requestedRoute;
        foreach ($this->freeUrls as $k => $v) {
            if ($v == $url) {
                $this->_isFree = true;
                return true;
            }
        }

        //controller
        $controller = $this->_action->controller->id;
        foreach ($this->freeControllers as $k => $v) {
            if ($v == $controller) {
                $this->_isFree = true;
                return true;
            }
        }

        return false;
    }

    protected function guestRedirect()
    {
        //if ($this->_isFree == true) {
        //    return;
        //}
        if (Yii::$app->getUser()->getIsGuest()) {
            $url = Yii::$app->urlManager->createUrl("site/login");

            //$this->redirect($url);
            Yii::$app->response->redirect($url);
        }
    }

    protected function checkAuth()
    {
        if (Yii::$app->user->identity == null) {
            return false;
        }

        if (Yii::$app->user->identity->isRoot()) {
            return false;
        }

        $userId = Yii::$app->user->identity->getId();
        //$action = $this->module->requestedRoute;
        $action = $this->_action->controller->module->requestedRoute;
        $menus = AccessMenu::getMenu();
        $bool = true;

        foreach ($menus as $k => $v) {
            if ($action == $v["url"][0]) {
                $bool = false;
            }
        }

        //if ($bool == true && (false == Yii::$app->user->identity->isRoot())) {
        if ($bool == true) {
            $uniqueId = $this->_action->getUniqueId();

            if ($uniqueId === Yii::$app->getErrorHandler()->errorAction) {
                return false;
            } else {
                throw new ForbiddenHttpException();
            }
        }
    }
}