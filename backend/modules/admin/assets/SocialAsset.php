<?php
namespace backend\modules\admin\assets;

use yii\web\AssetBundle;

/**
 * Менеджер ресурсов backend-модуля [[Admin]] Demo
 */
class SocialAsset extends AssetBundle
{
    public $sourcePath = '@backend/modules/admin/assets';
    public $css = [
        'css/plugins/social-buttons/social-buttons.css'
    ];
    public $js = [

    ];
    public $depends = [
    ];
}