<?php
namespace backend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use backend\controllers\BaseController;
use backend\models\Roles;
use backend\models\Access;

class RoleController extends BaseController
{
    public function actionIndex()
    {
        $searchModel = new Roles();
        $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());

        return $this->render("index", [
            "searchModel" => $searchModel,
            "dataProvider" => $dataProvider
        ]);
    }

    public function actionCreate()
    {
        $model = new Roles();

        if ($model->load(Yii::$app->getRequest()->getBodyParams()) && $model->validate()){
            $model->add();
            Yii::$app->session->setFlash("success", "添加成功");
            $this->redirect(Yii::$app->urlManager->createUrl("role/index"));
        }

        return $this->render("create", [
            'model' => $model,
        ]);
    }

    public function actionUpdate()
    {
        $id = Yii::$app->getRequest()->getQueryParam("id", 0);
        $model = Roles::find()->where(["id" => $id])->one();

        if (!$model) {
            throw new NotFoundHttpException();
        }

        if ($model->load(Yii::$app->getRequest()->getBodyParams()) && $model->validate()){
            $model->edit();
            Yii::$app->session->setFlash("success", "修改成功");
            $this->redirect(Yii::$app->urlManager->createUrl("role/index"));
        }

        return $this->render("update", [
            'model' => $model,
        ]);
    }

    public function actionDelete()
    {
        $id = Yii::$app->getRequest()->getQueryParam("id", 0);
        $model = Roles::find()->where(["id" => $id])->one();

        if (!$model) {
            throw new NotFoundHttpException();
        }

        $model->delete();

        return $this->redirect(Yii::$app->urlManager->createUrl("role/index"));
    }

    public function actionView()
    {
        $id = Yii::$app->getRequest()->getQueryParam("id", 0);
        $model = Roles::find()->where(["id" => $id])->one();
        if (!$model) {
            throw new NotFoundHttpException();
        }

        return $this->render("view", [
            "model" => $model,
        ]);
    }

    public function actionAccess()
    {
        $id = Yii::$app->getRequest()->getQueryParam("id");
        $model = new Access();
        $selectModel = Access::find()->where(["role_id" => $id])->asArray()->all();
        $data = Yii::$app->getRequest()->getBodyParams();

        if ($model->load($data) && $model->validate()) {
            $model->add();

            return $this->redirect(Yii::$app->urlManager->createUrl("role/index"));
        } else {
            return $this->render("access", [
                "model" => $model,
                "selectModel" => json_encode($selectModel),
                "role_id" => $id,
            ]);
        }

    }
}