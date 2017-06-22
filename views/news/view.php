<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use app\widgets\Notifications;

?>

<article class="news">
    <h1><?= Html::encode($model->title) ?></h1>

    <?= Notifications::widget() ?>

    <?php if($model->imageSrc): ?>
        <p>
            <?= Html::img($model->imageSrc, [
                'alt' => 'Image is not attached to this news.',
            ]) ?>
        </p>
    <?php endif; ?>
    <?= \Yii::$app->formatter->asParagraphs($model->text) ?>
</article>
