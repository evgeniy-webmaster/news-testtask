<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<h1><?= Yii::$app->request->serverName . ': ' . Html::encode($news->title) ?></h1>

<p>Click <?= Html::a('here', Url::to(['news/view', 'id' => $news->id], true)) ?>
    to read news.
</p>
