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
            ['label' => '10,', 'url' => ['index', 'per-page' => 10, 'page' => $pages->page], 'active' => $pages->limit == 10],
            ['label' => '20,', 'url' => ['index', 'per-page' => 20, 'page' => $pages->page], 'active' => $pages->limit == 20],
            ['label' => '50', 'url' => ['index', 'per-page' => 50, 'page' => $pages->page], 'active' => $pages->limit == 50],
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
