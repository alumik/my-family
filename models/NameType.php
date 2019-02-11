<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "name_type".
 *
 * @property int $id
 * @property string $name
 *
 * @property NameGraph[] $nameGraphs
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
            [['name'], 'required'],
            [['name'], 'string', 'max' => 10],
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
        return $this->hasMany(NameGraph::className(), ['type' => 'id']);
    }

    public static function getNameTypeList()
    {
        $result = NameType::find()
            ->select('name')
            ->orderBy('id')
            ->asArray()
            ->all();
        return ArrayHelper::getColumn($result, 'name');
    }
}
