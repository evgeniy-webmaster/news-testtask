<?php

namespace app\controllers;

use Yii;
use app\models\News;
use app\models\NewsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\web\ForbiddenHttpException;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsAdminController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'create'],
                        'roles' => ['manager'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update', 'status-change', 'delete'],
                        'roles' => ['manager'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all News models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->view->registerJsFile('/js/news-admin.js', [
            'depends' => [
                \app\assets\AppAsset::classname(),
                \app\assets\PjaxAsset::classname(),
            ],
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new News model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new News();

        if ($model->load(Yii::$app->request->post())) {
            $model->image = UploadedFile::getInstance($model, 'image');
            if($model->save())
                return $this->redirect(['index']);
        }

        return $this->renderPartial('create', [
            'model' => $model,
        ]);
    }

    protected function canChange($model)
    {
        if(Yii::$app->user->identity->role == 'manager' &&
           !Yii::$app->user->can('editOwnNews', ['news' => $model]))
            throw new ForbiddenHttpException('You may edit only own news.');
    }

    /**
     * Updates an existing News model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $this->canChange($model);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->renderPartial('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionStatusChange()
    {
        $post = Yii::$app->request->post();
        $model = $this->findModel($post['id']);
        $this->canChange($model);
        $model->status = (bool)$post['value'];
        $model->save();
    }

    /**
     * Deletes an existing News model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $this->canChange($model);
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
