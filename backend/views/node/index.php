<?php
use yii\grid\GridView;
use yii\helpers\Html;

?>
<div class="gridview-container">
    <div class="btn btn-primary">
        <a href="<?= Yii::$app->urlManager->createUrl('node/create') ?>" class="">添加路由</a>
    </div>
    <?= GridView::widget([
        'layout' => "{items}\n{summary}\n{pager}",
        'tableOptions' => ['class' => 'table table-striped table-hover table-bordered'],
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            "is_show",
            "pid",
            "msg",
            "url",
            "created_at",
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('app', 'OPTIONS'),
                'template' => "{update}{delete}",
            ],
        ],
    ]);
    ?>
</div>