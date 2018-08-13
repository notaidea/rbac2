<?php
namespace backend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use backend\controllers\BaseController;
use backend\models\Users;
use backend\models\Roles;
use backend\models\Userrole;

class UserController extends BaseController
{
    public function actionIndex()
    {
        $searchModel = new Users();
        $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());

        return $this->render("index", [
            "searchModel" => $searchModel,
            "dataProvider" => $dataProvider
        ]);
    }

    public function actionCreate()
    {
        $model = new Users();

        if ($model->load(Yii::$app->getRequest()->getBodyParams()) && $model->validate()){
            $model->add();
            Yii::$app->session->setFlash("success", "添加成功");
            $this->redirect(Yii::$app->urlManager->createUrl("user/index"));
        }

        return $this->render("create", [
            'model' => $model,
        ]);
    }

    public function actionUpdate()
    {
        $id = Yii::$app->getRequest()->getQueryParam("id", 0);
        $model = Users::find()->where(["id" => $id])->one();

        if (!$model) {
            throw new NotFoundHttpException();
        }

        $model->password_hash = "******";

        if ($model->load(Yii::$app->getRequest()->getBodyParams()) && $model->validate()){
            $model->edit();
            Yii::$app->session->setFlash("success", "修改成功");
            $this->redirect(Yii::$app->urlManager->createUrl("user/index"));
        }

        return $this->render("update", [
            'model' => $model,
        ]);
    }

    public function actionDelete()
    {
        $id = Yii::$app->getRequest()->getQueryParam("id", 0);
        $model = Users::find()->where(["id" => $id])->one();

        if (!$model) {
            throw new NotFoundHttpException();
        }

        $model->status = 0;
        $model->save(false);

        return $this->redirect(Yii::$app->urlManager->createUrl("user/index"));
    }

    public function actionUserrole()
    {
        $id = Yii::$app->getRequest()->getQueryParam("id", 0);
        $model = new Userrole();
        $roleModel = new Roles();
        $data = Yii::$app->getRequest()->getBodyParams();

        if ($model->load($data) && $model->validate()) {
            $model->add();

            return $this->redirect(Yii::$app->urlManager->createUrl("user/index"));
        } else {
            return $this->render("userrole", [
                "model" => $model,
                "userId" => $id,
                "roleModel" => $roleModel,
                "selectModel" => json_encode($model->getRoles($id)),
            ]);
        }
    }
}