<?php

use yii\db\Migration;

/**
 * Class m190211_171945_create_name_node_db_part_1
 */
class m190211_171945_create_other_name_db extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('name_out', [
            'id' => $this->primaryKey(),
            'generation' => $this->integer()->notNull(),
            'gender' => $this->integer()->notNull(),
            'name' => $this->string(255)->notNull(),
        ]);

        $this->addForeignKey(
            'name_out_gender_fk',
            'name_out',
            'gender',
            'gender',
            'id'
        );

        $this->batchInsert('name_out',
            ['id', 'generation', 'gender', 'name'],
            [
                [1, 0, 1, '哥哥/弟弟'],
                [2, 0, 2, '姐姐/妹妹'],
                [3, -1, 1, '叔叔'],
                [4, -1, 2, '阿姨'],
                [5, -2, 1, '爷爷'],
                [6, -2, 2, '婆婆'],
            ]
        );

        $this->createTable('name_node', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'gender' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'name_node_gender_fk',
            'name_node',
            'gender',
            'gender',
            'id'
        );

        $this->batchInsert(
            'name_node',
            ['id', 'name', 'gender'],
            [
                [1, '本人', 1],
                [2, '爸爸', 2],
                [3, '妈妈', 3],
                [4, '爷爷', 2],
                [5, '婆婆', 3],
                [6, '%number%爸', 2],
                [7, '%second_number%妈', 3],
                [8, '%order%堂兄弟', 2],
                [9, '%number%爷', 2],
                [10, '%order%姑婆', 3],
                [11, '祖父', 2],
                [12, '祖母', 3],
                [13, '兄弟', 2],
                [14, '姐妹', 3],
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

        $this->createIndex(
            'name_graph_uk',
            'name_graph',
            ['node', 'type'],
            true
        );

        $this->createIndex(
            'name_graph_uk_2',
            'name_graph',
            ['node', 'related_node'],
            true
        );

        $this->batchInsert(
            'name_graph',
            ['id', 'node', 'related_node', 'type'],
            [
                [1, 1, 2, 1], [2, 2, 13, 5], [3, 1, 3, 2], [4, 3, 13, 5], [5, 2, 3, 8],
                [6, 3, 2, 7], [7, 2, 4, 1], [8, 4, 6, 5], [9, 2, 5, 2], [10, 5, 6, 5],
                [11, 4, 5, 8], [12, 5, 4, 7], [13, 2, 6, 3], [14, 6, 6, 3], [15, 6, 7, 8],
                [16, 7, 6, 7], [17, 7, 8, 5], [18, 8, 7, 2], [19, 6, 8, 5], [20, 8, 6, 1],
                [21, 4, 11, 1], [22, 11, 9, 5], [23, 4, 12, 2], [24, 12, 9, 5], [25, 11, 12, 8],
                [26, 12, 11, 7], [27, 4, 9, 3], [28, 4, 10, 4], [29, 9, 9, 3], [30, 10, 10, 4],
                [31, 9, 10, 4], [32, 10, 9, 3], [33,10,11,1], [34,10,12,2], [35, 11, 10, 6],
                [36, 12, 10, 6], [37, 14, 2, 1], [38, 14, 3, 2], [39, 2, 14, 6], [40, 3, 14, 6],
                [41, 1, 13, 3], [42, 13, 13, 3], [43, 1, 14, 4], [44, 13, 14, 4], [45, 14, 13, 3],
                [46, 6, 4, 1], [47, 6, 5, 2], [48, 13, 2, 1], [49, 13, 3, 2], [50, 9, 11, 1],
                [51, 9, 12, 2],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('name_graph');

        $this->dropTable('name_node');

        $this->dropTable('name_out');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190211_171945_create_name_node_db_part_1 cannot be reverted.\n";

        return false;
    }
    */
}
