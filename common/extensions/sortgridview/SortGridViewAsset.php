<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace common\extensions\sortgridview;

use yii\web\AssetBundle;

/**
 * This asset bundle provides the javascript files for the [[GridView]] widget.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class SortGridViewAsset extends AssetBundle
{
    public $sourcePath = '@common/extensions/sortgridview/assets';
    public $js = [
        'js/jquery-ui.min.js',
    ];
    /*public $publishOptions = [
        'forceCopy'=>true
    ];*/
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset'
    ];
}
