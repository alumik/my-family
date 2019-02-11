<?php

use yii\db\Migration;

/**
 * Class m190211_165940_create_relation_name_db
 */
class m190211_165940_create_relation_name_db extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('name_node', [
            'id' => $this->primaryKey(),
            'name' => $this->string(10)->notNull(),
        ]);

        $this->createTable('name_type', [
            'id' => $this->primaryKey(),
            'name' => $this->string(10)->notNull(),
        ]);

        $this->batchInsert(
            'name_type',
            ['id', 'name'],
            [
                [1, '父亲'],
                [2, '母亲'],
                [3, '兄弟'],
                [4, '姐妹'],
                [5, '儿子'],
                [6, '女儿'],
            ]
        );

        $this->createTable('name_graph', [
            'id' => $this->primaryKey(),
            'node' => $this->integer()->notNull(),
            'related_node' => $this->integer()->notNull(),
            'type' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'name_graph_name_node_fk',
            'name_graph',
            'node',
            'name_node',
            'id'
        );

        $this->addForeignKey(
            'name_graph_name_node_fk_2',
            'name_graph',
            'related_node',
            'name_node',
            'id'
        );

        $this->addForeignKey(
            'name_graph_name_type_fk',
            'name_graph',
            'type',
            'name_type',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190211_165940_create_relation_name_db cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190211_165940_create_relation_name_db cannot be reverted.\n";

        return false;
    }
    */
}
