<?php

namespace app\controllers;

use app\models\Notify;
use yii\filters\VerbFilter;

class NotifyController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionDelete($id)
    {
        Notify::findOne(['id' => $id, 'userId' => \Yii::$app->user->identity->id])
            ->delete();
    }
}
