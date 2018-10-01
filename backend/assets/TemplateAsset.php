<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class TemplateAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/template_style.css',
        'css/jquery-ui.css',
        'css/jquery.fancybox.css',
    ];
    public $js = [
        'js/jquery-ui.min.js',
        'js/jquery.fancybox.pack.js',
        '../addon/ckeditor/ckeditor.js',
        'js/translite.js',
        'js/admin-action.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
