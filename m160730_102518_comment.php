<?php

use yii\db\Schema;
use yii\db\Migration;

class m160730_102518_comment extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%comment}}',
            [
                'id' => Schema::TYPE_PK . "",
                'created' => Schema::TYPE_INTEGER . "(11) NOT NULL",
                'updated' => Schema::TYPE_INTEGER . "(11) NOT NULL",
                'create_user_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
                'update_user_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
                'class' => Schema::TYPE_STRING . "(255) NOT NULL",
                'object_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
                'parent_id' => Schema::TYPE_INTEGER . "(11) NOT NULL DEFAULT '0'",
                'status' => Schema::TYPE_INTEGER . "(11) NOT NULL DEFAULT '0'",
                'content' => Schema::TYPE_TEXT . " NOT NULL",
            ],
            $tableOptions
        );

        $this->createIndex('updated', '{{%comment}}', 'updated', 0);
        $this->createIndex('update_user_id', '{{%comment}}', 'update_user_id', 0);
        $this->createIndex('parent_id', '{{%comment}}', 'parent_id', 0);
        $this->createIndex('object_id', '{{%comment}}', 'object_id', 0);
    }

    public function safeDown()
    {
        $this->dropTable('{{%comment}}');
    }
}
