<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "relation_type".
 *
 * @property int $id
 * @property string $name
 *
 * @property Relation[] $relations
 */
class RelationType extends \yii\db\ActiveRecord
{
    public static $QINZI = 1;
    public static $FUQI = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'relation_type';
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
    public function getRelations()
    {
        return $this->hasMany(Relation::className(), ['type' => 'id']);
    }

    /**
     * @return array
     */
    public static function getRelationTypeList()
    {
        $result = [];
        $list = RelationType::find()->all();
        if (!empty($list)) {
            $result = ArrayHelper::map($list, 'id', 'name');
        }
        return $result;
    }
}
