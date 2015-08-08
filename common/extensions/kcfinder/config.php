<?php

/** This file is part of KCFinder project
  *
  *      @desc Base configuration file
  *   @package KCFinder
  *   @version 3.12
  *    @author Pavel Tzonkov <sunhater@sunhater.com>
  * @copyright 2010-2014 KCFinder Project
  *   @license http://opensource.org/licenses/GPL-3.0 GPLv3
  *   @license http://opensource.org/licenses/LGPL-3.0 LGPLv3
  *      @link http://kcfinder.sunhater.com
  */

/* IMPORTANT!!! Do not comment or remove uncommented settings in this file
   even if you are using session configuration.
   See http://kcfinder.sunhater.com/install for setting descriptions */

namespace common\extensions\kcfinder;

use Yii;

class Config {

    public function __construct()
    {
        $this->items['uploadDir'] = Yii::getAlias('@root') . '/statics/web/content/images';
        $this->items['uploadURL'] = Yii::$app->params['staticsDomain'] . '/content/images';
        $this->items['uploadURL'] = Yii::$app->params['staticsDomain'] . '/statics/web/content/images';
    }

    public function getItems()
    {
        return $this->items;
    }

    protected $items = [
        'disabled' => false,
        'theme' => "default",

        'types' => [

            // (F)CKEditor types
            'files'   =>  "",
            'flash'   =>  "swf",
            'images'  =>  "*img",

            // TinyMCE types
            'file'    =>  "",
            'media'   =>  "swf flv avi mpg mpeg qt mov wmv asf rm",
            'image'   =>  "*img",
        ],


// IMAGE SETTINGS

        'imageDriversPriority' => "imagick gmagick gd",
        'jpegQuality' => 90,
        'thumbsDir' => ".thumbs",

        'maxImageWidth' => 0,
        'maxImageHeight' => 0,

        'thumbWidth' => 100,
        'thumbHeight' => 100,

        'watermark' => "",


// DISABLE / ENABLE SETTINGS

        'denyZipDownload' => false,
        'denyUpdateCheck' => false,
        'denyExtensionRename' => false,


// PERMISSION SETTINGS

        'dirPerms' => 0755,
        'filePerms' => 0644,

        'access' => [

            'files' => [
                'upload' => true,
                'delete' => true,
                'copy'   => true,
                'move'   => true,
                'rename' => true
            ],

            'dirs' => [
                'create' => true,
                'delete' => true,
                'rename' => true
            ]
        ],

        'deniedExts' => "exe com msi bat cgi pl php phps phtml php3 php4 php5 php6 py pyc pyo pcgi pcgi3 pcgi4 pcgi5 pchi6",


// MISC SETTINGS

        'filenameChangeChars' => [],

        'dirnameChangeChars' => [],

        'mime_magic' => "",

        'cookieDomain' => "",
        'cookiePath' => "",
        'cookiePrefix' => 'KCFINDER_',


// THE FOLLOWING SETTINGS CANNOT BE OVERRIDED WITH SESSION SETTINGS

        '_normalizeFilenames' => false,
        '_check4htaccess' => true,

        '_sessionVar' => "KCFINDER"

    ];

}

?>