<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "person".
 *
 * @property int $id
 * @property string $family_name
 * @property string $given_name
 * @property string $birth_date
 * @property int $gender
 * @property int $alive
 * @property string $description
 *
 * @property Relationship[] $relationships
 * @property Relationship[] $relationships0
 */
class Person extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'person';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['birth_date'], 'safe'],
            [['gender', 'alive'], 'integer'],
            [['description'], 'string'],
            [['family_name', 'given_name'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'family_name' => 'Family Name',
            'given_name' => 'Given Name',
            'birth_date' => 'Birth Date',
            'gender' => 'Gender',
            'alive' => 'Alive',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelationships()
    {
        return $this->hasMany(Relationship::className(), ['parent' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelationships0()
    {
        return $this->hasMany(Relationship::className(), ['child' => 'id']);
    }
}
