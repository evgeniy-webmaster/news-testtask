<?php

/*
 * This file is part of the Dektrium project
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\User $user
 */
?>

<?php $form = ActiveForm::begin([]); ?>

<?= $form->field($user, 'email')->textInput(['maxlength' => 255]) ?>
<?= $form->field($user, 'username')->textInput(['maxlength' => 255]) ?>
<?= $form->field($user, 'password')->passwordInput() ?>
<?= $form->field($user, 'role')->radioList($user->roles()) ?>
<?= $form->field($user, 'get_emails')->checkbox() ?>
<?= $form->field($user, 'get_browser_notify')->checkbox() ?>

<div class="form-group">
    <?= Html::submitButton('Update', ['class' => 'btn btn-block btn-success']) ?>
    <?= Html::a('Delete', ['/user-admin/delete', 'id' => $user->id], [
        'class' => 'btn btn-block btn-danger',
        'data-method' => 'POST',
    ]) ?>
</div>

<?php ActiveForm::end(); ?>
