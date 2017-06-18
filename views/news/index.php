<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\Menu;

?>
<h1>News</h1>

<div>
    Max news on the page: <?= Menu::widget([
        'options' => [
            'id' => 'limitMenu',
        ],
        'items' => [
            ['label' => '10,', 'url' => ['index', 'limit' => 10], 'active' => $limit == 10],
            ['label' => '20,', 'url' => ['index', 'limit' => 20], 'active' => $limit == 20],
            ['label' => '50', 'url' => ['index', 'limit' => 50], 'active' => $limit == 50],
        ]
    ]) ?> .
</div>

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
