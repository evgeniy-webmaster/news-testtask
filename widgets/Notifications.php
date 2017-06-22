<?php

namespace app\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use app\models\Notify;

class Notifications extends Widget
{
    public function init()
    {
        $this->view->registerJsFile('/js/notifications-widget.js', [
            'depends' => [
                \app\assets\AppAsset::classname(),
            ],
        ]);
    }

    public function run()
    {
        $ret = '';
        if(!\Yii::$app->user->isGuest) {
            $ns = Notify::find()->where(['userId' => \Yii::$app->user->identity->id])
                ->asArray()
                ->all();
            foreach($ns as $n) {
                $ret .= '<div class="alert alert-success clearfix">' . $n['message'] .
                    '<button class="btn btn-default removeNotify" data-id="' .
                    $n['id'] . '"><span class="glyphicon glyphicon-remove"></span></button></div>';
            }
        }
        return $ret;
    }
}
