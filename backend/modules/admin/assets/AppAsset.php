<?php
namespace backend\modules\admin\assets;

use yii\web\AssetBundle;

/**
 * Менеджер ресурсов backend-модуля [[Admin]]
 */
class AppAsset extends AssetBundle
{
//    public $forceCopy = true;
	public $sourcePath = '@backend/modules/admin/assets';
	public $css = [
        'font-awesome/css/font-awesome.css',
        'css/plugins/morris/morris-0.4.3.min.css',
        'css/plugins/timeline/timeline.css',
        'css/sb-admin.css',
        'css/stats.css',
    ];
    public $js=[
        'js/bootstrap.min.js',
        'js/plugins/metisMenu/jquery.metisMenu.js',
        'js/sb-admin.js',
        'js/app.js'
	];

	public $depends = [
		'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset'
	];
    public $jsOptions = ['position' => \yii\web\View::POS_END];
    /*public $publishOptions = [
        'forceCopy'=>true
    ];*/
}