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
     * @return array
     */
    public static function getNameTypeList()
    {
        $result = self::find()->all();
        return ArrayHelper::getColumn($result, 'name');
    }
}
