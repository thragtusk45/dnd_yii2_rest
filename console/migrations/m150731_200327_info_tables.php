<?php

use yii\db\Schema;
use yii\db\Migration;

class m150731_200327_info_tables extends Migration
{
    public function up()
    {
        $this->createTable('info_table',[
            'id' => 'pk',
            'title' => Schema::TYPE_STRING.'(255) NOT NULL',
            'type' => Schema::TYPE_INTEGER.'(3) DEFAULT 0',
            'content' => Schema::TYPE_TEXT.' NOT NULL',
        ]);
    }

    public function down()
    {
        $this->dropTable('info_table');
        echo "m150731_200327_info_tables reverted.\n";

        return false;
    }
}
