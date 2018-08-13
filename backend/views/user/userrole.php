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
        <?= $form->field($model, "role_id")->checkboxList($roleModel->getRolesOpt()); ?>
        <?= $form->field($model, "user_id")->hiddenInput(["value" => $userId]); ?>
        <div class="form-group">
            <?= Html::submitButton("提交"); ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>
<?php JsBlock::begin(); ?>
<script>
    $(function(){
        var data = <?= $selectModel; ?>;

        $(".field-userrole-role_id input").each(function(index, which) {
            var which = $(this);
            var id = $(this).val();

            for (i = 0; i < data.length; i++) {
                if (id == data[i].role_id) {
                    which.attr("checked", true);
                }
            }
        });
    })
</script>
<?php JsBlock::end(); ?>