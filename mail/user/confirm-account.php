<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<h1>Confirm your account</h1>

<p>
    Your login is <?= Html::encode($username) ?>.
    <?= Html::a('Click to confirm.', Url::to(['site/confirm', 'key' => $key], true)) ?>
</p>
