<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<h1>Your password has been changed</h1>

<p>
    Your login <?= Html::encode($username) ?>.
    Please, ask for help to the <?= Html::mailto('admin', \Yii::$app->params['adminEmail']) ?>
</p>
