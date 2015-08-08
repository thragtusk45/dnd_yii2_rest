<?php
namespace common\extensions\multicrop\assets;

use yii\web\AssetBundle;

/**
 * Пакет продвинутой загрузки.
 */
class MultiCropAsset extends AssetBundle
{
	public $sourcePath = '@common/extensions/multicrop/assets';

	public $css = [
	    'css/advanced.css',
        'vendor/jquery.fileapi/the-modal/the-modal.css',
        'vendor/jquery.fileapi/jcrop/jquery.Jcrop.min.css'
	];

    public $js = [
        'vendor/jquery.fileapi/FileAPI/FileAPI.min.js',
        'vendor/jquery.fileapi/jquery.fileapi.min.js',
        'vendor/jquery.fileapi/jcrop/jquery.Jcrop.min.js',
        'vendor/jquery.fileapi/the-modal/jquery.modal.js',
        'js/multicrop.js'
    ];

	public $depends = [
        'yii\web\JqueryAsset',
	    'yii\web\YiiAsset',
	    'yii\bootstrap\BootstrapAsset'
	];

//    public $publishOptions = ['forceCopy' => true];

}