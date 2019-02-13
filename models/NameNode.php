<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "name_node".
 *
 * @property int $id
 * @property string $name
 * @property int $gender
 *
 * @property NameGraph[] $nameGraphs
 * @property NameGraph[] $nameGraphs0
 * @property NameNode[] $relatedNodes
 * @property NameNode[] $nodes
 * @property NameType[] $types
 * @property Gender $gender0
 */
class NameNode extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'name_node';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'gender'], 'required'],
            [['gender'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['gender'], 'exist', 'skipOnError' => true, 'targetClass' => Gender::className(), 'targetAttribute' => ['gender' => 'id']],
        ];
    }

    /**
     * checked
     * @param $type
     * @return array|NameGraph|null
     */
    public function getNameGraph($type)
    {
        return $this->hasMany(NameGraph::className(), ['node' => 'id'])->where(['type' => $type])->one();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNameGraphs()
    {
        return $this->hasMany(NameGraph::className(), ['node' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNameGraphs0()
    {
        return $this->hasMany(NameGraph::className(), ['related_node' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getRelatedNodes()
    {
        return $this->hasMany(NameNode::className(), ['id' => 'related_node'])->viaTable('name_graph', ['node' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getNodes()
    {
        return $this->hasMany(NameNode::className(), ['id' => 'node'])->viaTable('name_graph', ['related_node' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getTypes()
    {
        return $this->hasMany(NameType::className(), ['id' => 'type'])->viaTable('name_graph', ['node' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGender0()
    {
        return $this->hasOne(Gender::className(), ['id' => 'gender']);
    }
}
