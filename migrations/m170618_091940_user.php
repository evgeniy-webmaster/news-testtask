<?php

use yii\db\Migration;

class m170618_091940_user extends Migration
{
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->char(255)->notNull(),
            'email' => $this->char(255)->notNull(),
            'password_hash' => $this->char(60)->notNull(),
            'created_at' => $this->integer(11)->notNull(),
            'confirmed' => $this->boolean()->notNull(),
            'last_login_at' => $this->integer(11)->notNull(),
            'get_emails' => $this->boolean()->notNull(),
            'get_browser_notify' => $this->boolean()->notNull(),
        ]);

        $this->createIndex('username', 'user', 'username(191)', true);
        $this->createIndex('email', 'user', 'email(191)', true);
    }

    public function safeDown()
    {
        $this->dropTable('user');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170621_161717_user cannot be reverted.\n";

        return false;
    }
    */
}
