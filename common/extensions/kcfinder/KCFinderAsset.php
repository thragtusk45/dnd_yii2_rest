<?php
namespace common\extensions\kcfinder;

use yii\web\AssetBundle;

/**
 * Пакет мульти-загрузки
 */
class KCFinderAsset extends AssetBundle
{
	public $sourcePath = '@common/extensions/kcfinder/assets';
	public $css = [
	    'css/base.css',
        'themes/default/ui.css',
        'themes/default/misc.css'
	];
    public $js = [
        'js/_jquery.js',
        'js/jqueryui.js',
        'js/jquery.uniform.js',
        'js/jquery.fixes.js',
        'js/jquery.rightClick.js',
        'js/jquery.taphold.js',
        'js/jquery.agent.js',
        'js/jquery.helper.js',
        'js/jquery.md5.js',
        'js/object.js',
        'js/dialogs.js',
        'js/init.js',
        'js/toolbar.js',
        'js/settings.js',
        'js/files.js',
        'js/folders.js',
        'js/menus.js',
        'js/viewImage.js',
        'js/clipboard.js',
        'js/dropUpload.js',
        'js/misc.js',
        'themes/default/init.js'
    ];

    public $publishOptions = ['forceCopy' => true];

}