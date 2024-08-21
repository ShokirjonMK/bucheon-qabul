<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%options}}`.
 */
class m240803_064230_add_order_column_to_options_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('options' , 'order' , $this->integer()->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
