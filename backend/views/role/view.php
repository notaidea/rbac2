<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->render("_blocks", ["model" => $model]);
?>
<div class="show-form">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'UPDATE'), ['update'], [
            'class' => 'btn btn-default btn-clickbtn',
            'data' => [
                'method' => 'POST',
                'params' => [
                    'id' => $model->id,
                ],
            ],
        ]) ?>
        <?= Html::a(Yii::t('app', 'DELETE'), ['delete'], [
            'class' => 'btn btn-default btn-clickbtn',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'POST',
                'params' => [
                    'id' => $model->id,
                ],
            ],
        ]) ?>

        <!--
        <?= Html::a(Yii::t('app', '编辑'), ['update', 'id' => $model->id], ['class' => 'btn btn-clickbtn']) ?>
        <?= Html::a(Yii::t('app', '删除'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-default btn-clickbtn',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        -->
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'options' => ["class" => "table table-striped  detail-view"],
        'attributes' => [
            'name',
            'msg',
            [
                'format' => 'raw',
                'label' => "拥有的权限",
                "value" => $this->blocks["node"],
            ]
            /*
            [
                'label'=>'广告',
                'format' => 'raw',
                'value' => Html::img($model->imguri1, ["id" => "imageBtn_holder"]),
            ],
            */
        ],
    ]);
    ?>
</div>