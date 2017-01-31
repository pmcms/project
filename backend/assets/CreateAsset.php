<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Asset สร้างงาน layout
 * Main backend application asset bundle.
 */
class CreateAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $css = [
    		'createasset/css/components-md.min.css',
    		'createasset/css/plugins-md.min.css',
    		'createasset/css/jquery-ui.css',
    		'createasset/css/jquery.datetimepicker.css',
    		'createasset/css/jquery.datetimepicker.css',
    ];
   public $cssOptions = ['position' => \yii\web\View::POS_HEAD];
    
    public $js = [
    		'createasset/js/jquery.js',
    		'createasset/js/moment.min.js',
    		'createasset/js/bootstrap.min.js',
    		'createasset/js/select2.full.min.js',
    		'createasset/js/jquery.validate.min.js',
    		'createasset/js/additional-methods.min.js',
    		'createasset/js/jquery.bootstrap.wizard.min.js',
    		'createasset/js/form-validate.js',
    		'createasset/js/jquery.datetimepicker.js',
    		'createasset/js/app.js',
    		'createasset/js/form-wizard.js',
    		'createasset/js/validate-date-time.js',
    		'createasset/js/setting-date-time.js',
    		'createasset/js/jquery.inputmask.bundle.js',
    		'createasset/js/form-input-mask.js',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_END];
    
    public $depends = [
    		'yii\web\YiiAsset',
    		'yii\bootstrap\BootstrapAsset',
    ];
}
