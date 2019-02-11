<?php

use yii\db\Migration;

/**
 * Class m190211_133057_create_basic_db
 */
class m190211_133057_create_basic_db extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('gender', [
            'id' => $this->primaryKey(),
            'name' => $this->string(10)->notNull(),
        ]);

        $this->batchInsert(
            'gender',
            ['id', 'name'],
            [
                [1, '未知'],
                [2, '男'],
                [3, '女'],
            ]
        );

        $this->createTable('person', [
            'id' => $this->primaryKey(),
            'family_name' => $this->string(10)->null(),
            'given_name' => $this->string(10)->null(),
            'birth_date' => $this->date()->null(),
            'gender' => $this->integer()->notNull(),
            'alive' => $this->tinyInteger()->notNull(),
            'my_relationship' => $this->string(255)->null(),
            'phone' => $this->string(20)->null(),
            'description' => $this->text(),
        ]);

        $this->addForeignKey(
            'person_gender_id_fk',
            'person',
            'gender',
            'gender',
            'id'
        );

        $this->createTable('relation_type', [
            'id' => $this->primaryKey(),
            'name' => $this->string(10)->notNull(),
        ]);

        $this->batchInsert(
            'relation_type',
            ['id', 'name'],
            [
                [1, '亲子'],
                [2, '夫妻'],
            ]
        );

        $this->createTable('relationship', [
            'id' => $this->primaryKey(),
            'parent' => $this->integer()->notNull(),
            'child' => $this->integer()->notNull(),
            'type' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'relationship_person_id_fk',
            'relationship',
            'parent',
            'person',
            'id'
        );

        $this->addForeignKey(
            'relationship_person_id_fk_2',
            'relationship',
            'child',
            'person',
            'id'
        );

        $this->addForeignKey(
            'relationship_relation_type_id_fk',
            'relationship',
            'type',
            'relation_type',
            'id'
        );

        $this->createIndex(
            'relationship_uk',
            'relationship',
            ['parent', 'child'],
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190211_133057_create_basic_db cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190211_133057_create_basic_db cannot be reverted.\n";

        return false;
    }
    */
}
