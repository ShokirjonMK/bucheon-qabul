<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%student_group}}`.
 */
class m240820_053518_create_student_group_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            // https://stackoverflow.com/questions/51278467/mysql-collation-utf8mb4-unicode-ci-vs-utf8mb4-default-collation
            // https://www.eversql.com/mysql-utf8-vs-utf8mb4-whats-the-difference-between-utf8-and-utf8mb4/
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=InnoDB';
        }

        $tableName = Yii::$app->db->tablePrefix . 'student_group';
        if (!(Yii::$app->db->getTableSchema($tableName, true) === null)) {
            $this->dropTable('student_group');
        }

        $this->createTable('{{%student_group}}', [
            'id' => $this->primaryKey(),
            'std_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),

            'drift_id' => $this->integer()->null(),
            'drift_form_id' => $this->integer()->null(),
            'drift_course_id' => $this->integer()->null(),
            'edu_year_id' => $this->integer()->null(),
            'language_id' => $this->integer()->null(),
            'course_id' => $this->integer()->null(),
            'etype_id' => $this->integer()->null(),

            'price' => $this->float()->defaultValue(0),

            'status' => $this->tinyInteger(1)->defaultValue(0),
            'created_at'=>$this->integer()->null(),
            'updated_at'=>$this->integer()->null(),
            'created_by' => $this->integer()->null()->defaultValue(0),
            'updated_by' => $this->integer()->null()->defaultValue(0),
            'is_deleted' => $this->tinyInteger()->notNull()->defaultValue(0),
        ], $tableOptions);
        $this->addForeignKey('ik_student_group_table_std_table', 'student_group', 'std_id', 'std', 'id');
        $this->addForeignKey('ik_student_group_table_user_table', 'student_group', 'user_id', 'user', 'id');
        $this->addForeignKey('ik_student_group_table_drift_table', 'student_group', 'drift_id', 'drift', 'id');
        $this->addForeignKey('ik_student_group_table_drift_form_table', 'student_group', 'drift_form_id', 'drift_form', 'id');
        $this->addForeignKey('ik_student_group_table_drift_course_table', 'student_group', 'drift_course_id', 'drift_course', 'id');
        $this->addForeignKey('ik_student_group_table_edu_year_table', 'student_group', 'edu_year_id', 'edu_year', 'id');
        $this->addForeignKey('ik_student_group_table_language_table', 'student_group', 'language_id', 'languages', 'id');
        $this->addForeignKey('ik_student_group_table_course_table', 'student_group', 'course_id', 'course', 'id');
        $this->addForeignKey('ik_student_group_table_etype_table', 'student_group', 'etype_id', 'etype', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%student_group}}');
    }
}
