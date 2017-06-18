<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'News';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::button('Create News', [
            'id' => 'createBtn',
            'class' => 'btn btn-success',
            'data-toggle' => 'modal',
            'data-target' => '#newsForm',
        ]) ?>
    </p>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <!-- Modal -->
    <div class="modal fade" id="newsForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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

<?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            'created_at:datetime',
            [
                'attribute' => 'title',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::a($model->title, ['update', 'id' => $model->id], [
                        'class' => 'newsUpdate',
                    ]);
                }
            ],
            'shortText',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::checkbox('status[]', $model->status, [
                        'class' => 'statusAjaxControl',
                        'data-modelId' => $model->id,
                    ]);
                },
            ]
        ],
    ]); ?>
<?php Pjax::end(); ?>

</div>
