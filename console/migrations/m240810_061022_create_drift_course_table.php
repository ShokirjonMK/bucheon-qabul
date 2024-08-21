<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%drift_course}}`.
 */
class m240810_061022_create_drift_course_table extends Migration
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

        $tableName = Yii::$app->db->tablePrefix . 'drift_course';
        if (!(Yii::$app->db->getTableSchema($tableName, true) === null)) {
            $this->dropTable('drift_course');
        }

        $this->createTable('{{%drift_course}}', [
            'id' => $this->primaryKey(),
            'drift_form_id' => $this->integer()->notNull(),
            'course_id' => $this->integer()->notNull(),
            'price' => $this->float()->notNull(),
            'edu_year_id' => $this->integer()->notNull(),

            'status' => $this->tinyInteger(1)->defaultValue(0),
            'created_at'=>$this->integer()->null(),
            'updated_at'=>$this->integer()->null(),
            'created_by' => $this->integer()->notNull()->defaultValue(0),
            'updated_by' => $this->integer()->notNull()->defaultValue(0),
            'is_deleted' => $this->tinyInteger()->notNull()->defaultValue(0),
        ], $tableOptions);
        $this->addForeignKey('ik_drift_course_form_table_drift_form_table', 'drift_course', 'drift_form_id', 'drift_form', 'id');
        $this->addForeignKey('ik_drift_course_form_table_course_table', 'drift_course', 'course_id', 'course', 'id');
        $this->addForeignKey('ik_drift_course_form_table_edu_year_table', 'drift_course', 'edu_year_id', 'edu_year', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%drift_course}}');
    }
}
