<?php

use yii\db\Migration;

class m170622_080106_notify extends Migration
{
    public function safeUp()
    {
        $this->createTable('notify', [
            'id' => $this->primaryKey(),
            'userId' => $this->integer(11)->notNull(),
            'message' => $this->string('300')->notNull(),
        ]);

        $this->createIndex('userId', 'notify', 'userId');
        $this->addForeignKey('userId', 'notify', 'userId', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable('notify');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170622_080106_notify cannot be reverted.\n";

        return false;
    }
    */
}
