<?php
/**
 * Created by PhpStorm.
 * User: Alexey
 * Date: 12.08.2015
 * Time: 21:52
 */

namespace common\modules\tools\models;


class MountainTown extends Town {

    public function __construct(Town $town) {
        $this->resources['metal']['common']['iron']+=50;
        $this->resources['metal']['common']['copper']+=50;
        $this->resources['metal']['uncommon']['silver']+=15;
        $this->resources['metal']['uncommon']['gold']+=10;
        $this->resources['metal']['rare']['platinum']+=5;
        $this->resources['metal']['legendary']['adamantium']+=0.5;
    }
} 