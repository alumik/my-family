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
                [7, '丈夫'],
                [8, '妻子'],
            ]
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
