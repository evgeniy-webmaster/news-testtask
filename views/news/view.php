<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

?>

<article class="news">
    <h1><?= Html::encode($model->title) ?></h1>
    <?php if($model->imageSrc): ?>
        <?= Html::img($model->imageSrc, [
            'alt' => 'Image is not attached to this news.',
        ]) ?>
    <?php endif; ?>
    <?= \Yii::$app->formatter->asParagraphs($model->text) ?>
</article>
