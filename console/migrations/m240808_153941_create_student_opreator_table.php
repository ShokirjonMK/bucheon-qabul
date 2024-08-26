<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%student_operator}}`.
 */
class m240808_153941_create_student_opreator_table extends Migration
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

        $tableName = Yii::$app->db->tablePrefix . 'student_operator';
        if (!(Yii::$app->db->getTableSchema($tableName, true) === null)) {
            $this->dropTable('student_operator');
        }

        $this->createTable('{{%student_operator}}', [
            'id' => $this->primaryKey(),
            'student_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'date' => $this->integer()->notNull(),
            'student_operator_type_id' => $this->integer()->notNull(),
            'text' => $this->text()->null(),
            'is_deleted' => $this->integer()->defaultValue(0)
        ], $tableOptions);
        $this->addForeignKey('ik_student_operator_table_student_table', 'student_operator', 'student_id', 'student', 'id');
        $this->addForeignKey('ik_student_operator_table_user_table', 'student_operator', 'user_id', 'user', 'id');
        $this->addForeignKey('ik_student_operator_table_student_operator_type_table', 'student_operator', 'student_operator_type_id', 'student_operator_type', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%student_operator}}');
    }
}
