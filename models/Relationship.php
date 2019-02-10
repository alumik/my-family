<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "relationship".
 *
 * @property int $id
 * @property int $parent
 * @property int $child
 *
 * @property Person $parent0
 * @property Person $child0
 */
class Relationship extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'relationship';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent', 'child'], 'required'],
            [['parent', 'child'], 'integer'],
            [['parent'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['parent' => 'id']],
            [['child'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['child' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent' => '父/母',
            'child' => '子/女',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent0()
    {
        return $this->hasOne(Person::className(), ['id' => 'parent']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChild0()
    {
        return $this->hasOne(Person::className(), ['id' => 'child']);
    }
}
