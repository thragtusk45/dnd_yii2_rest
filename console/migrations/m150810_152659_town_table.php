<?php

use yii\db\Schema;
use yii\db\Migration;

class m150810_152659_town_table extends Migration
{
    public function up()
    {
        $this->createTable('town',[
            'id' => 'pk',
            'name' => Schema::TYPE_STRING.'(255) NOT NULL',
            'race' => Schema::TYPE_STRING.'(40) NOT NULL',
            'terrain' => Schema::TYPE_STRING.'(40) NOT NULL',
            'has_river' => Schema::TYPE_INTEGER.'(1) NOT NULL DEFAULT 1',
            'has_sea' => Schema::TYPE_INTEGER.'(1) NOT NULL DEFAULT 0',
            'type' => Schema::TYPE_INTEGER.'(1) NOT NULL DEFAULT 0',
            'has_mountains' => Schema::TYPE_INTEGER.'(1) NOT NULL DEFAULT 0',
            'size' => Schema::TYPE_INTEGER.'(1) NOT NULL DEFAULT 0',
            'resources' => Schema::TYPE_TEXT,
            'artisans' => Schema::TYPE_TEXT,
        ]);
    }

    public function down()
    {
        $this->dropTable('town');
        echo "m150810_152659_town_table reverted.\n";

        return false;
    }
}
