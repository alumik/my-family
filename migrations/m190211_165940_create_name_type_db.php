<?php

use yii\db\Migration;

/**
 * Class m190211_165940_create_relation_name_db
 */
class m190211_165940_create_name_type_db extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('name_type', [
            'id' => $this->primaryKey(),
            'name' => $this->string(10)->notNull(),
            'generation' => $this->integer()->notNull(),
        ]);

        $this->batchInsert(
            'name_type',
            ['id', 'name', 'generation'],
            [
                [1, '父亲', -1],
                [2, '母亲', -1],
                [3, '兄弟', 0],
                [4, '姐妹', 0],
                [5, '儿子', 1],
                [6, '女儿', 1],
                [7, '丈夫', 0],
                [8, '妻子', 0],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('name_type');
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
