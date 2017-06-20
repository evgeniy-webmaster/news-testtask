<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $roleAdmin = $auth->createRole('admin');
        $auth->add($roleAdmin);

        $roleManager = $auth->createRole('manager');
        $auth->add($roleManager);

        $roleUser = $auth->createRole('user');
        $auth->add($roleUser);

        $isNewsAuthor = new \app\rbac\NewsAuthorRule();
        $auth->add($isNewsAuthor);

        $pEditOwnNews = $auth->createPermission('editOwnNews');
        $pEditOwnNews->ruleName = $isNewsAuthor->name;
        $auth->add($pEditOwnNews);

        $auth->addChild($roleManager, $pEditOwnNews);
    }

    public function actionClear()
    {
        Yii::$app->db->createCommand('SET foreign_key_checks = 0')->execute();
        Yii::$app->db->createCommand('TRUNCATE TABLE {{auth_assignment}}')->execute();
        Yii::$app->db->createCommand('TRUNCATE TABLE {{auth_item}}')->execute();
        Yii::$app->db->createCommand('TRUNCATE TABLE {{auth_item_child}}')->execute();
        Yii::$app->db->createCommand('TRUNCATE TABLE {{auth_rule}}')->execute();
    }
}
