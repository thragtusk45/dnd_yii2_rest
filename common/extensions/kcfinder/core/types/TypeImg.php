<?php

/** This file is part of KCFinder project
  *
  *      @desc Image detection class
  *   @package KCFinder
  *   @version 3.10
  *    @author Pavel Tzonkov <sunhater@sunhater.com>
  * @copyright 2010-2014 KCFinder Project
  *   @license http://opensource.org/licenses/GPL-3.0 GPLv3
  *   @license http://opensource.org/licenses/LGPL-3.0 LGPLv3
  *      @link http://kcfinder.sunhater.com
  */

namespace common\extensions\kcfinder\core\types;

use common\extensions\kcfinder\lib\Image;

class TypeImg {

    public function checkFile($file, array $config) {

        $driver = isset($config['imageDriversPriority'])
            ? Image::getDriver(explode(" ", $config['imageDriversPriority'])) : "gd";

        $img = Image::factory($driver, $file);

        if ($img->initError)
            return "Unknown image format/encoding.";

        return true;
    }
}

?>