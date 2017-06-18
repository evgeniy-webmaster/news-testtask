<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datetimepicker\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\NewsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
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
            <?= $form->field($model, 'title') ?>

            <?= $form->field($model, 'shortText') ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'status')->dropDownList([null => '', 0 => 'Unactive', 1 => 'Active']) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Reset', ['/news-admin'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
