<?php
namespace backend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use backend\controllers\BaseController;
use backend\models\Nodes;

class NodeController extends BaseController
{
    public function actionIndex()
    {
        $searchModel = new Nodes();
        $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());

        return $this->render("index", [
            "searchModel" => $searchModel,
            "dataProvider" => $dataProvider
        ]);
    }

    public function actionCreate()
    {
        $model = new Nodes();

        if ($model->load(Yii::$app->getRequest()->getBodyParams()) && $model->validate()){
            $model->add();
            Yii::$app->session->setFlash("success", "添加成功");
            $this->redirect(Yii::$app->urlManager->createUrl("node/index"));
        }

        return $this->render("create", [
            'model' => $model,
        ]);
    }

    public function actionUpdate()
    {
        $id = Yii::$app->getRequest()->getQueryParam("id", 0);
        $model = Nodes::find()->where(["id" => $id])->one();

        if (!$model) {
            throw new NotFoundHttpException();
        }

        if ($model->load(Yii::$app->getRequest()->getBodyParams()) && $model->validate()){
            $model->edit();
            Yii::$app->session->setFlash("success", "修改成功");
            $this->redirect(Yii::$app->urlManager->createUrl("node/index"));
        }

        return $this->render("update", [
            'model' => $model,
        ]);
    }

    public function actionDelete()
    {
        $id = Yii::$app->getRequest()->getQueryParam("id", 0);
        $model = Nodes::find()->where(["id" => $id])->one();

        if (!$model) {
            throw new NotFoundHttpException();
        }

        $model->delete();

        return $this->redirect(Yii::$app->urlManager->createUrl("node/index"));
    }


    public function actionTest()
    {
        //todo note 直接die掉的话是无法进行权限检测的
        echo "node/test";
        die;
    }
    /*
    public function actionTest()
    {
        $searchModel = new Nodes();
        $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());

        return $this->render("index", [
            "searchModel" => $searchModel,
            "dataProvider" => $dataProvider
        ]);
    }
    */
}