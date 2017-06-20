<?php

namespace app\controllers;

use app\models\News;
use yii\data\Pagination;

class NewsController extends \yii\web\Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['view'],
                'rules' => [
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $query = News::find()->where(['status' => 1]);
        $countQuery = clone $query;
        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
        ]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', ['model' => $this->findModel($id)]);
    }

    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
