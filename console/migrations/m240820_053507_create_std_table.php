<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%std}}`.
 */
class m240820_053507_create_std_table extends Migration
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

        $tableName = Yii::$app->db->tablePrefix . 'std';
        if (!(Yii::$app->db->getTableSchema($tableName, true) === null)) {
            $this->dropTable('std');
        }

        $this->createTable('{{%std}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),

            'first_name' => $this->string(255)->null(),
            'last_name' => $this->string(255)->null(),
            'middle_name' => $this->string(255)->null(),

            'student_phone' => $this->string(100)->null(),
            'adress' => $this->text()->null(),

            'gender' => $this->tinyInteger(1)->null(),
            'birthday' => $this->date()->null(),
            'passport_number' => $this->string(255)->null(),
            'passport_serial' => $this->string(255)->null(),
            'passport_pin' => $this->string(255)->null(),
            'passport_issued_date' => $this->string(255)->null(),
            'passport_given_date' => $this->string(255)->null(),
            'passport_given_by' => $this->string(255)->null(),

            'status' => $this->tinyInteger(1)->defaultValue(1),
            'created_at'=>$this->integer()->null(),
            'updated_at'=>$this->integer()->null(),
            'created_by' => $this->integer()->null()->defaultValue(0),
            'updated_by' => $this->integer()->null()->defaultValue(0),
            'is_deleted' => $this->tinyInteger()->notNull()->defaultValue(0),
        ], $tableOptions);
        $this->addForeignKey('ik_std_table_user_table', 'std', 'user_id', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%std}}');
    }
}
