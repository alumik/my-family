<?php

use yii\db\Migration;

/**
 * Class m190211_171945_create_name_node_db_part_1
 */
class m190211_171945_create_name_node_db_part_1 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('name_type', ['id' => 7, 'name' => '丈夫']);
        $this->insert('name_type', ['id' => 8, 'name' => '妻子']);

        $this->batchInsert(
            'name_node',
            ['id', 'name'],
            [
                [1, '我'],
                [2, '爸爸'],
                [3, '妈妈'],
                [4, '爷爷'],
                [5, '婆婆'],
                [6, '大/二/幺爸'],
                [7, '大/二/幺妈'],
                [8, '堂弟'],
                [9, '大/二/幺爷'],
                [10, '姑婆'],
                [11, '祖祖'],
                [12, '祖母'],
            ]
        );

        $this->batchInsert(
            'name_graph',
            ['id', 'node', 'related_node', 'type'],
            [
                [1, 1, 2, 1], [2, 2, 1, 5], [3, 1, 3, 2], [4, 3, 1, 5], [5, 2, 3, 8],
                [6, 3, 2, 7], [7, 2, 4, 1], [8, 4, 2, 5], [9, 2, 5, 2], [10, 5, 2, 5],
                [11, 4, 5, 8], [12, 5, 4, 7], [13, 2, 6, 3], [14, 6, 6, 3], [15, 6, 7, 8],
                [16, 7, 6, 7], [17, 7, 8, 5], [18, 8, 7, 2], [19, 6, 8, 5], [20, 8, 6, 1],
                [21, 6, 4, 1], [22, 4, 6, 5], [23, 6, 5, 2], [24, 5, 6, 5], [25, 4, 11, 1],
                [26, 11, 4, 5], [27, 4, 12, 2], [28, 12, 4, 5], [29, 11, 12, 8], [30, 12, 11, 7],
                [31, 4, 9, 3], [32, 4, 10, 4], [33, 9, 9, 3], [34, 10, 10, 4], [35, 9, 10, 4],
                [36, 10, 9, 3], [37, 9, 11, 1], [38, 9,12,2], [39,10,11,1], [40,10,12,2],
                [41, 11, 9, 5], [42, 12, 9 ,5], [43, 11, 10, 6], [44, 12, 10, 6],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190211_171945_create_name_node_db_part_1 cannot be reverted.\n";

        return false;
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
