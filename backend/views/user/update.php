<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<div class="create-show-form">
    <?php
        $form = ActiveForm::begin([
            "options" => ["class" => "form-inline",],
            //"enableClientValidation" => false,
        ]);
    ?>
        <?= $form->field($model, "username")->textInput(); ?>
        <?= $form->field($model, "password_hash")->passwordInput(); ?>
        <div class="form-group">
            <?= Html::submitButton("提交"); ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>
