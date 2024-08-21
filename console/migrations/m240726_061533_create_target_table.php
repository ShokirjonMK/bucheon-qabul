<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%target}}`.
 */
class m240726_061533_create_target_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%target}}', [
            'id' => $this->primaryKey(),
            'type' => $this->integer()->defaultValue(0),
            'name' => $this->string(255)->notNull(),
            'created_at'=>$this->integer()->null(),
            'updated_at'=>$this->integer()->null(),
            'created_by' => $this->integer()->defaultValue(0),
            'updated_by' => $this->integer()->defaultValue(0),
            'is_deleted' => $this->tinyInteger()->notNull()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%target}}');
    }
}
