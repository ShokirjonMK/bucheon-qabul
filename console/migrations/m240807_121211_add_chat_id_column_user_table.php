<?php

use yii\db\Migration;

/**
 * Class m240807_121211_add_chat_id_column_user_table
 */
class m240807_121211_add_chat_id_column_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user' , 'chat_id' , $this->string(255)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240807_121211_add_chat_id_column_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240807_121211_add_chat_id_column_user_table cannot be reverted.\n";

        return false;
    }
    */
}
