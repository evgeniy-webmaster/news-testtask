<?php

use yii\db\Migration;
use yii\db\Schema;

class m170618_091941_news extends Migration
{
    public function safeUp()
    {
        $this->createTable('news', [
            'id' => $this->primaryKey(),
            'authorId' => $this->integer()->notNull(),
            'title' => $this->string(150)->notNull(),
            'shortText' => $this->string(500)->notNull(),
            'text' => $this->text()->notNull(),
            'status' => $this->boolean()->notNull(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
        ]);

        $this->createIndex('authorId', 'news', 'authorId');
        $this->addForeignKey(
            'authorId',
            'news',
            'authorId',
            'user',
            'id',
            'RESTRICT',
            'RESTRICT'
        );
    }

    public function safeDown()
    {
        $this->dropTable('news');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170618_091941_news cannot be reverted.\n";

        return false;
    }
    */
}
