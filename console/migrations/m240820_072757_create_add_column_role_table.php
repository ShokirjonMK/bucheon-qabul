<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%add_column_role}}`.
 */
class m240820_072757_create_add_column_role_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $director = $auth->createRole('std');
        $director->description = 'Talaba';
        $auth->add($director);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%add_column_role}}');
    }
}
