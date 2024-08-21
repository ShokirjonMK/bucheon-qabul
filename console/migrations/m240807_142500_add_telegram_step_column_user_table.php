<?php

use yii\db\Migration;

/**
 * Class m240807_142500_add_telegram_step_column_user_table
 */
class m240807_142500_add_telegram_step_column_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'telegram_step' , $this->integer()->defaultValue(0));
        $this->addColumn('user', 'lang_id' , $this->integer()->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240807_142500_add_telegram_step_column_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240807_142500_add_telegram_step_column_user_table cannot be reverted.\n";

        return false;
    }
    */
}
