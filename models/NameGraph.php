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
}
