<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "name_node".
 *
 * @property int $id
 * @property string $name
 *
 * @property NameGraph[] $nameGraphs
 * @property NameGraph[] $nameGraphs0
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
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
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
}
