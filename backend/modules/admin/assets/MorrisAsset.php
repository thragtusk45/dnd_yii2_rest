<?php
namespace backend\modules\admin\assets;

use yii\web\AssetBundle;

/**
 * Менеджер ресурсов backend-модуля [[Admin]] Demo
 */
class MorrisAsset extends AssetBundle
{
    public $sourcePath = '@backend/modules/admin/assets';
    public $css = [
    ];
    public $js = [

        'js/plugins/morris/raphael-2.1.0.min.js',
        'js/plugins/morris/morris.js',
        'js/demo/morris-demo.js',

    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'backend\modules\admin\assets\AppAsset'
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_END];
}