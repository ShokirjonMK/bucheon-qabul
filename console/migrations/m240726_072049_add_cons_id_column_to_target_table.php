<?php

use yii\db\Migration;

class m240726_072049_add_cons_id_column_to_target_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('target' , 'cons_id', $this->integer()->defaultValue(1));
        $this->addForeignKey('ik_target_table_cons_table', 'target', 'cons_id', 'constalting', 'id');
    }
}
