<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use common\JsBlock;
?>

<div class="create-show-form">
    <?php
        $form = ActiveForm::begin([
            "options" => ["class" => "form-inline",],
            //"enableClientValidation" => false,
        ]);
    ?>
        <?= $form->field($model, "node_id")->checkboxList($model->getNodes()); ?>
        <?= $form->field($model, "role_id")->hiddenInput(["value" => $role_id]); ?>
        <div class="form-group">
            <?= Html::submitButton("提交"); ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>
<?php JsBlock::begin(); ?>
<script>
    $(function(){
        var data = <?= $selectModel; ?>;


        $("#access-node_id input").each(function(index, which) {
            var which = $(this);
            var id = $(this).val();

            for (i = 0; i < data.length; i++) {
                if (id == data[i].node_id) {
                    which.attr("checked", true);
                }
            }
        });
    })
</script>
<?php JsBlock::end(); ?>