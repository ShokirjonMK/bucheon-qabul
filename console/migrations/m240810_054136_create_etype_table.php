<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%etype}}`.
 */
class m240810_054136_create_etype_table extends Migration
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

        $tableName = Yii::$app->db->tablePrefix . 'etype';
        if (!(Yii::$app->db->getTableSchema($tableName, true) === null)) {
            $this->dropTable('etype');
        }


        $this->createTable('{{%etype}}', [
            'id' => $this->primaryKey(),
            'name_uz' => $this->string(255)->notNull(),
            'name_ru' => $this->string(255)->notNull(),
            'name_en' => $this->string(255)->notNull(),
        ], $tableOptions);

        $this->insert('{{%etype}}', [
            'name_uz' => 'Bakalavr',
            'name_ru' => 'Холостяк',
            'name_en' => 'Bachelor',
        ]);

        $this->insert('{{%etype}}', [
            'name_uz' => 'Magistratura',
            'name_ru' => 'Магистра',
            'name_en' => 'Master\'s',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%etype}}');
    }
}
