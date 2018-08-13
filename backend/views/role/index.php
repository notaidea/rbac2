<?php
use yii\grid\GridView;
use yii\helpers\Html;

?>
<div class="gridview-container">
    <div class="btn btn-primary">
        <a href="<?= Yii::$app->urlManager->createUrl('role/create') ?>" class="">添加角色</a>
    </div>
    <?= GridView::widget([
        'layout' => "{items}\n{summary}\n{pager}",
        'tableOptions' => ['class' => 'table table-striped table-hover table-bordered'],
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            "name",
            "msg",
            "created_at",
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('app', 'OPTIONS'),
                'template' => "{update}{view}{delete}{access}",
                'buttons' => [
                    'access' => function($url, $model, $key) {
                        return Html::a("角色权限管理", $url);
                    },
                ],
            ],
        ],
    ]);
    ?>
</div>