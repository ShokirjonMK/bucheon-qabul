<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%std}}`.
 */
class m240810_134207_add_student_step_confirm_time_column_tostd_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user' , 'step_confirm_time' , $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
