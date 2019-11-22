<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800" rel="stylesheet',
        'lib/bootstrap/css/bootstrap.min.css',
        'lib/font-awesome/css/font-awesome.min.css',
        'lib/animate/animate.min.css',
        'lib/venobox/venobox.css',
        'lib/owlcarousel/assets/owl.carousel.min.css',
        'css/style.css',
        'css/custom.css'
    ];
    public $js = [
        'lib/jquery/jquery.min.js',
        'lib/jquery/jquery-migrate.min.js',
        'lib/bootstrap/js/bootstrap.bundle.min.js',
        'lib/easing/easing.min.js',
        'lib/superfish/hoverIntent.js',
        'lib/superfish/superfish.min.js',
        'lib/wow/wow.min.js',
        'lib/venobox/venobox.min.js',
        'lib/owlcarousel/owl.carousel.min.js',
        'contactform/contactform.js',
        'js/main.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        // 'yii\bootstrap\BootstrapAsset',
    ];
}
