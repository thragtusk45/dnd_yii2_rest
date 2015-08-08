<?php
namespace common\extensions\gallery\assets;

use yii\web\AssetBundle;

/**
 * Пакет мульти-загрузки
 */
class GalleryAsset extends AssetBundle
{
	public $sourcePath = '@common/extensions/gallery/assets';
	public $css = [
	    'css/multiple.css'
	];
    public $js = [
        'vendor/jquery.fileapi/FileAPI/FileAPI.min.js',
        'vendor/jquery.fileapi/jquery.fileapi.min.js',
        'js/jquery-ui.min.js',
        'js/gallery.js'
    ];
	public $depends = [
        'yii\web\JqueryAsset'
	];

//    public $publishOptions = ['forceCopy' => true];

}