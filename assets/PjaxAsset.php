<?php

namespace app\assets;

use yii\web\AssetBundle;

class PjaxAsset extends AssetBundle
{
    //public $basePath = '@webroot';
    //public $baseUrl = '@web';
    public $sourcePath = '@app/vendor/bower/yii2-pjax';
    public $css = [
    ];
    public $js = [
        'jquery.pjax.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
