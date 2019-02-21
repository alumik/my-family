<?php

use yii\db\Migration;

/**
 * Class m190220_081019_delete_name_db
 */
class m190220_081019_delete_name_db extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('name_graph');

        $this->dropTable('name_node');

        $this->dropTable('name_out');

        $this->dropTable('name_type');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190220_081019_delete_name_db cannot be reverted.\n";

        return false;
    }
}
