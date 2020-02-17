<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css?v=0.2',
        'css/jquery-ui.css',
        'css/jquery.timepicker.css',
    ];
    public $js = [
        //'js/jquery.geocomplete.min.js','position' => \yii\web\View::POS_HEAD,
       ['js/jquery-1.11.0.js','position' => \yii\web\View::POS_HEAD],
        'js/jquery-ui.js?v=0.1',
        'js/backend.js?v=0.1',
        'js/tag-it.js',
         'js/jquery.timepicker.js',
         'js/custom.js?v=5.2',
         'js/app.js?v=0.1',
        // 'js/bootstrap-select.js?v=0.1',
       // 'js/croppi.js?v=0.3'
       // 'js/jquery.geocomplete.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}


