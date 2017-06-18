<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;

?>
<h1>News</h1>

<div class="news-container">
<?php foreach ($models as $model): ?>
    <article class="news">
        <h2><?= Html::a($model->title, ['view', 'id' => $model->id]) ?></h2>
        <?= \Yii::$app->formatter->asParagraphs($model->shortText) ?>
    </article>
<?php endforeach; ?>
</div>

<?= LinkPager::widget([
    'pagination' => $pages,
]) ?>
