<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%student}}`.
 */
class m240808_155600_add_std_operator_column_to_student_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('student' , 'student_operator_type_id' , $this->integer()->null());
        $this->addColumn('student' , 'student_operator_id' , $this->integer()->null());
        $this->addForeignKey('ik_student_table_student_operator_type_table', 'student', 'student_operator_type_id', 'student_operator_type', 'id');
        $this->addForeignKey('ik_student_table_student_operator_table', 'student', 'student_operator_id', 'student_operator', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
