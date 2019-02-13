<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "name_node".
 *
 * @property int $id
 * @property string $name
 * @property int $gender
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
     * @param $type
     * @return array|NameGraph|null
     */
    public function getNameGraph($type)
    {
        return $this->hasMany(NameGraph::className(), ['node' => 'id'])->where(['type' => $type])->one();
    }
}
