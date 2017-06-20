<?php

namespace app\controllers;

use dektrium\user\controllers\AdminController as BaseAdminController;
use dektrium\user\models\UserSearch;
use app\models\User;
use app\assets\PjaxAsset;

class UserAdminController extends BaseAdminController
{
    public function actionIndex()
    {
        $searchModel  = \Yii::createObject(UserSearch::className());
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        $this->view->registerJsFile('/js/user-admin.js', [
            'depends' => [
                \app\assets\AppAsset::classname(),
                PjaxAsset::classname(),
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
            'success' => \Yii::$app->session->getFlash('success'),
        ]);
    }

    public function actionCreate()
    {
        /** @var User $user */
        $user = \Yii::createObject([
            'class'    => User::className(),
            'scenario' => 'create',
        ]);
        $event = $this->getUserEvent($user);

        $this->trigger(self::EVENT_BEFORE_CREATE, $event);
        if ($user->load(\Yii::$app->request->post()) && $user->create()) {
            \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'User has been created'));
            $this->trigger(self::EVENT_AFTER_CREATE, $event);
            return $this->redirect(['index']);
        }

        return $this->renderPartial('create', [
            'user' => $user,
        ]);
    }

    public function actionUpdate($id)
    {
        $user = $this->findModel($id);
        $user->scenario = 'update';
        $event = $this->getUserEvent($user);

        $this->trigger(self::EVENT_BEFORE_UPDATE, $event);
        if ($user->load(\Yii::$app->request->post()) && $user->save()) {
            \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Account details have been updated'));
            $this->trigger(self::EVENT_AFTER_UPDATE, $event);
            return $this->redirect('/user/admin');
        }

        return $this->renderPartial('_account', [
            'user' => $user,
        ]);
    }

    public function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
