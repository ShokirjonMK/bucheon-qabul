<?php

use yii\db\Migration;

/**
 * Class m240820_151226_add_invois_student_group_table
 */
class m240820_151226_add_invois_student_group_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('student_group' , 'down_time' , $this->integer()->null());
        $this->addColumn('student_group' , 'contract_second' , $this->string(255)->null());
        $this->addColumn('student_group' , 'contract_third' , $this->string(255)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240820_151226_add_invois_student_group_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240820_151226_add_invois_student_group_table cannot be reverted.\n";

        return false;
    }
    */
}
