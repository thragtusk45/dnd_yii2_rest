<?php
namespace backend\modules\admin\assets;

use yii\web\AssetBundle;

/**
 * Менеджер ресурсов backend-модуля [[Admin]] Demo
 */
class FlotAsset extends AssetBundle
{
    public $sourcePath = '@backend/modules/admin/assets';
    public $css = [
    ];
    public $js = [

        'js/plugins/flot/excanvas.min.js',
        'js/plugins/flot/jquery.flot.js',
        'js/plugins/flot/jquery.flot.tooltip.min.js',
        'js/plugins/flot/jquery.flot.resize.js',
        'js/plugins/flot/jquery.flot.pie.js',
        'js/demo/flot-demo.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'backend\modules\admin\assets\AppAsset'
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_END];
}