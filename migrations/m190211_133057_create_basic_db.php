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

        $this->createTable('blood_type', [
            'id' => $this->primaryKey(),
            'name' => $this->string(10)->notNull(),
        ]);

        $this->batchInsert(
            'blood_type',
            ['id', 'name'],
            [
                [1, '未知'],
                [2, 'A型'],
                [3, 'B型'],
                [4, 'AB型'],
                [5, 'O型'],
            ]
        );

        $this->createTable('person', [
            'id' => $this->primaryKey(),
            'family_name' => $this->string(10)->null(),
            'given_name' => $this->string(10)->null(),
            'birth_date' => $this->date()->notNull(),
            'inaccurate_birth_date' => $this->tinyInteger()->notNull(),
            'gender' => $this->integer()->notNull(),
            'blood_type' => $this->integer()->notNull(),
            'id_card' => $this->string(18)->null(),
            'alive' => $this->tinyInteger()->notNull(),
            'my_relation' => $this->string(255)->null(),
            'phone' => $this->string(20)->null(),
        ]);

        $this->addForeignKey(
            'person_gender_id_fk',
            'person',
            'gender',
            'gender',
            'id'
        );

        $this->addForeignKey(
            'person_blood_type_id_fk',
            'person',
            'blood_type',
            'blood_type',
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

        $this->createTable('relation', [
            'id' => $this->primaryKey(),
            'parent' => $this->integer()->notNull(),
            'child' => $this->integer()->notNull(),
            'type' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'relation_person_id_fk',
            'relation',
            'parent',
            'person',
            'id'
        );

        $this->addForeignKey(
            'relation_person_id_fk_2',
            'relation',
            'child',
            'person',
            'id'
        );

        $this->addForeignKey(
            'relation_relation_type_id_fk',
            'relation',
            'type',
            'relation_type',
            'id'
        );

        $this->createIndex(
            'relation_uk',
            'relation',
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
