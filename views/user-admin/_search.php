<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use dosamigos\datetimepicker\DateTimePicker;


?>

<?php $form = ActiveForm::begin(['method' => 'get']); ?>

<div class="row">

    <div class="col-md-4">
        <?= $form->field($model, 'id') ?>
        <?= $form->field($model, 'username') ?>
        <?= $form->field($model, 'email') ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'minCreatedAt')->widget(DateTimePicker::className(), [
            'size' => 'ms',
            'template' => '{input}',
            'pickButtonIcon' => 'glyphicon glyphicon-time',
            'clientOptions' => [
                'startView' => 2,
                'minView' => 0,
                'maxView' => 2,
                'autoclose' => true,
                'linkFormat' => 'yyyy-MM-dd hh:ii',
                'todayBtn' => true
            ]
        ]) ?>
        <?= $form->field($model, 'maxCreatedAt')->widget(DateTimePicker::className(), [
            'size' => 'ms',
            'template' => '{input}',
            'pickButtonIcon' => 'glyphicon glyphicon-time',
            'clientOptions' => [
                'startView' => 2,
                'minView' => 0,
                'maxView' => 2,
                'autoclose' => true,
                'linkFormat' => 'yyyy-MM-dd hh:ii',
                'todayBtn' => true
            ]
        ]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'minLastLoginAt')->widget(DateTimePicker::className(), [
            'size' => 'ms',
            'template' => '{input}',
            'pickButtonIcon' => 'glyphicon glyphicon-time',
            'clientOptions' => [
                'startView' => 2,
                'minView' => 0,
                'maxView' => 2,
                'autoclose' => true,
                'linkFormat' => 'yyyy-MM-dd hh:ii',
                'todayBtn' => true
            ]
        ]) ?>
        <?= $form->field($model, 'maxLastLoginAt')->widget(DateTimePicker::className(), [
            'size' => 'ms',
            'template' => '{input}',
            'pickButtonIcon' => 'glyphicon glyphicon-time',
            'clientOptions' => [
                'startView' => 2,
                'minView' => 0,
                'maxView' => 2,
                'autoclose' => true,
                'linkFormat' => 'yyyy-MM-dd hh:ii',
                'todayBtn' => true
            ]
        ]) ?>

    </div>
</div>
    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Reset', ['/user-admin'], ['class' => 'btn btn-default']) ?>
    </div>

<?php ActiveForm::end(); ?>
