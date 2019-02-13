<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "name_type".
 *
 * @property int $id
 * @property string $name
 * @property int $generation
 * @property int $gender
 *
 * @property NameGraph[] $nameGraphs
 * @property NameNode[] $nodes
 * @property Gender $gender0
 */
class NameType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'name_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'generation', 'gender'], 'required'],
            [['generation', 'gender'], 'integer'],
            [['name'], 'string', 'max' => 10],
        ];
    }

    /**
     * checked
     * @return array
     */
    public static function getNameTypeList()
    {
        $result = self::find()->all();
        return ArrayHelper::getColumn($result, 'name');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNameGraphs()
    {
        return $this->hasMany(NameGraph::className(), ['type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getNodes()
    {
        return $this->hasMany(NameNode::className(), ['id' => 'node'])->viaTable('name_graph', ['type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGender0()
    {
        return $this->hasOne(Gender::className(), ['id' => 'gender']);
    }
}
