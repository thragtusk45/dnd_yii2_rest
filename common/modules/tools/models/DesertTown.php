<?php
/**
 * Created by PhpStorm.
 * User: Alexey
 * Date: 12.08.2015
 * Time: 22:02
 */

namespace common\modules\tools\models;


class DesertTown extends Town {

    public function __construct(Town $town) {

        $this->resources['metal']['uncommon']['gold']+=10;

    }
} 