<?php
/* @var $this yii\web\View */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

?>
<h1>User Administration</h1>

<?php if($success): ?>
    <div class="alert alert-success"><?= $success ?></div>
<?php endif; ?>

<p><?= Html::button('Create User', [
    'id' => 'createUserBtn',
    'class' => 'btn btn-success',
    'data-toggle' => 'modal',
    'data-target' => '#userForm',
]) ?></p>

<!-- Modal -->
<div class="modal fade" id="userForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
    </div>
  </div>
</div>

<?php Pjax::begin() ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    //'filterModel'  => $searchModel,
    'layout'       => "{items}\n{pager}",
    'columns' => [
        'id',
        [
            'attribute' => 'username',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::button($model->username, [
                    'class' => 'btn btn-primary userUpdateBtn',
                    'data-toggle' => 'modal',
                    'data-target' => '#userForm',
                    'data-userId' => $model->id,
                ]);
            },
        ],
        'email:email',
        'created_at:datetime',
        'last_login_at:datetime',
        /*
        [
            'attribute' => 'created_at',
            'value' => function ($model) {
                if (extension_loaded('intl')) {
                    return Yii::t('user', '{0, date, MMMM dd, YYYY HH:mm}', [$model->created_at]);
                } else {
                    return date('Y-m-d G:i:s', $model->created_at);
                }
            },
        ],
        [
          'attribute' => 'last_login_at',
          'value' => function ($model) {
            if (!$model->last_login_at || $model->last_login_at == 0) {
                return Yii::t('user', 'Never');
            } else if (extension_loaded('intl')) {
                return Yii::t('user', '{0, date, MMMM dd, YYYY HH:mm}', [$model->last_login_at]);
            } else {
                return date('Y-m-d G:i:s', $model->last_login_at);
            }
          },
        ],
        */
    ],
]); ?>

<?php Pjax::end() ?>
