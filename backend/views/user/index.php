<?php
use yii\grid\GridView;
use yii\helpers\Html;

?>
<div class="gridview-container">
    <div class="btn btn-primary">
        <a href="<?= Yii::$app->urlManager->createUrl('user/create') ?>" class="">添加用户</a>
    </div>
    <?= GridView::widget([
        'layout' => "{items}\n{summary}\n{pager}",
        'tableOptions' => ['class' => 'table table-striped table-hover table-bordered'],
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            /*
            [
                'attribute' => '房间',
                'value' => function($model) {
                    return $model->getAllid($model->allid);
                },
            ],
            */
            "username",
            "email",
            "created_at",
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('app', 'OPTIONS'),
                'template' => "{update}{delete}{userrole}",
                'buttons' => [
                    'userrole' => function($url, $model, $key) {
                        if ($model->id == 1) {
                            return "";
                        }

                        return Html::a("角色设置", $url);
                    },
                    /*
                    'delete' => function($url, $model, $key) {
                        $href = Yii::$app->urlManager->createUrl(["estatend/auth/delete"]);
                        return Html::a(
                            Yii::t('app', 'DELETE'),
                            $href,
                            [
                                'title' => Yii::t('app', 'DELETE'),
                                'class' => 'opt-links opt-links-del',
                                'data-confirm' => Yii::t('app', 'DELETE_CONFIRM'),
                                "data-method" => "post",
                                "data-params" => ["id" => $model->id]
                            ]);
                    },
                    */
                ],
            ],
        ],
    ]);
    ?>
</div>
