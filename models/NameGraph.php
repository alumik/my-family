<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "name_graph".
 *
 * @property int $id
 * @property int $node
 * @property int $related_node
 * @property int $type
 *
 * @property NameNode $node0
 * @property NameNode $relatedNode
 * @property NameType $type0
 */
class NameGraph extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'name_graph';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['node', 'related_node', 'type'], 'required'],
            [['node', 'related_node', 'type'], 'integer'],
            [['node'], 'exist', 'skipOnError' => true, 'targetClass' => NameNode::className(), 'targetAttribute' => ['node' => 'id']],
            [['related_node'], 'exist', 'skipOnError' => true, 'targetClass' => NameNode::className(), 'targetAttribute' => ['related_node' => 'id']],
            [['type'], 'exist', 'skipOnError' => true, 'targetClass' => NameType::className(), 'targetAttribute' => ['type' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'node' => 'Node',
            'related_node' => 'Related Node',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNode0()
    {
        return $this->hasOne(NameNode::className(), ['id' => 'node']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelatedNode()
    {
        return $this->hasOne(NameNode::className(), ['id' => 'related_node']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType0()
    {
        return $this->hasOne(NameType::className(), ['id' => 'type']);
    }
}
