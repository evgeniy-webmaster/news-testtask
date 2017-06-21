<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<h1>Set new password</h1>

<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>
