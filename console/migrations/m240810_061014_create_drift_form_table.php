<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%drift_form}}`.
 */
class m240810_061014_create_drift_form_table extends Migration
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

        $tableName = Yii::$app->db->tablePrefix . 'drift_form';
        if (!(Yii::$app->db->getTableSchema($tableName, true) === null)) {
            $this->dropTable('drift_form');
        }

        $this->createTable('{{%drift_form}}', [
            'id' => $this->primaryKey(),
            'drift_id' => $this->integer()->notNull(),
            'edu_dureation' => $this->float()->notNull(),
            'language_id' => $this->integer()->notNull(),
            'edu_form_id' => $this->integer()->notNull(),
            'edu_year_id' => $this->integer()->notNull(),

            'status' => $this->tinyInteger(1)->defaultValue(1),
            'created_at'=>$this->integer()->null(),
            'updated_at'=>$this->integer()->null(),
            'created_by' => $this->integer()->notNull()->defaultValue(0),
            'updated_by' => $this->integer()->notNull()->defaultValue(0),
            'is_deleted' => $this->tinyInteger()->notNull()->defaultValue(0),
        ], $tableOptions);
        $this->addForeignKey('ik_drift_form_table_drift_table', 'drift_form', 'drift_id', 'drift', 'id');
        $this->addForeignKey('ik_drift_form_table_language_table', 'drift_form', 'language_id', 'languages', 'id');
        $this->addForeignKey('ik_drift_form_table_edu_form_table', 'drift_form', 'edu_form_id', 'edu_form', 'id');
        $this->addForeignKey('ik_drift_form_table_edu_year_table', 'drift_form', 'edu_year_id', 'edu_year', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%drift_form}}');
    }
}
