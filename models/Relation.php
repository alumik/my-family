<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "relation".
 *
 * @property int $id
 * @property int $parent
 * @property int $child
 * @property int $type
 *
 * @property string $parent_name
 * @property string $child_name
 *
 * @property Person $parent0
 * @property Person $child0
 * @property RelationType $type0
 */
class Relation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'relation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent', 'child', 'type'], 'required'],
            [['parent', 'child', 'type'], 'integer'],
            [['parent', 'child'], 'unique', 'targetAttribute' => ['parent', 'child']],
            [['parent', 'child'], 'validatePair'],
            ['parent', 'compare', 'compareAttribute' => 'child', 'operator' => '!='],
            ['child', 'compare', 'compareAttribute' => 'parent', 'operator' => '!='],
            [['parent'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['parent' => 'id']],
            [['child'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['child' => 'id']],
            [['type'], 'exist', 'skipOnError' => true, 'targetClass' => RelationType::className(), 'targetAttribute' => ['type' => 'id']],
        ];
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function validatePair($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (Relation::find()
                ->where(['parent' => $this->child, 'child' => $this->parent])
                ->exists()) {
                $this->addError($attribute, '成员的相反关系已存在。');
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function fields()
    {
        return [
            'parent' => function ($model) {
                return $model->parent_name;
            },
            'child' => function ($model) {
                return $model->child_name;
            },
            'type' => function ($model) {
                return $model->type0->name;
            },
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent' => '父母/丈夫',
            'child' => '子女/妻子',
            'type' => '关系类型',

            'parent_name' => '父母/丈夫',
            'child_name' => '子女/妻子',
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

    /**
     * @return string
     */
    public function getParent_name()
    {
        return $this->parent0->full_name;
    }

    /**
     * @return string
     */
    public function getChild_name()
    {
        return $this->child0->full_name;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType0()
    {
        return $this->hasOne(RelationType::className(), ['id' => 'type']);
    }

    /**
     * @return integer
     */
    public static function getRelationsCount()
    {
        return Relation::find()->count();
    }
}
