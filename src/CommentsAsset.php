<?php

namespace floor12\comments;

use yii\web\AssetBundle;

class CommentsAsset extends AssetBundle
{

    public $publishOptions = [
        'forceCopy' => true,
    ];
    public $sourcePath = '@vendor/floor12/yii2-comments/assets/';
    public $css = [
        'comments.css'
    ];
    public $js = [
        'comments.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'rmrevin\yii\fontawesome\AssetBundle',
    ];

}
