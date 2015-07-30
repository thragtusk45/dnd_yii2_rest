<?php
namespace backend\modules\admin\assets;

use yii\web\AssetBundle;

/**
 * Менеджер ресурсов backend-модуля [[Admin]] Demo
 */
class TablesAsset extends AssetBundle
{
    public $sourcePath = '@backend/modules/admin/assets';
    public $css = [
    ];
    public $js = [

        'js/plugins/dataTables/jquery.dataTables.js',
        'js/plugins/dataTables/dataTables.bootstrap.js'

    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'backend\modules\admin\assets\AppAsset'
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_END];
}