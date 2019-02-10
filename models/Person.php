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
 * @property Gender $gender0
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
            [['my_relationship'], 'string', 'max' => 255],
            [['gender'], 'exist', 'skipOnError' => true, 'targetClass' => Gender::className(), 'targetAttribute' => ['gender' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'family_name' => '姓',
            'given_name' => '名',
            'full_name' => '姓名',
            'birth_date' => '出生日期',
            'age' => '年龄',
            'gender' => '性别',
            'alive' => '是否健在',
            'my_relationship' => '与我的关系',
            'description' => '备注',
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

    /**
     * @return string
     */
    public function getFull_name()
    {
        return $this->family_name . $this->given_name;
    }

    /**
     * @return string
     */
    public function getAlive_text()
    {
        return $this->alive == 1 ? '是' : '否';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGender0()
    {
        return $this->hasOne(Gender::className(), ['id' => 'gender']);
    }

    /**
     * @return string
     */
    public function getGender_name()
    {
        return $this->gender0->name;
    }

    /**
     * @return string|integer
     */
    public function getAge()
    {
        if ($this->birth_date) {
            $birth_date = $this->birth_date;
            list($birth_year, $birth_month, $birth_day) = explode('-', $birth_date);
            $cm = date('n');
            $cd = date('j');
            $age = date('Y') - $birth_year - 1;
            if ($cm > $birth_month || $cm == $birth_month && $cd > $birth_day) $age++;
            return $age;
        }
        return '';
    }
}
