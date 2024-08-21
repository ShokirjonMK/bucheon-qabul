<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%questions}}`.
 */
class m240803_054413_add_type_column_to_questions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('questions' , 'type' , $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
