<?php
namespace common\extensions\gallery\assets;

use yii\web\AssetBundle;

/**
 * Основной пакет виджета
 */
class FileAPIAsset extends AssetBundle
{
	public $sourcePath = '@common/extensions/gallery/assets';
	public $js = [
	    'vendor/jquery.fileapi/FileAPI/FileAPI.min.js',
	    'vendor/jquery.fileapi/jquery.fileapi.min.js'
	];
	public $depends = [
		'yii\web\JqueryAsset',
	];
}