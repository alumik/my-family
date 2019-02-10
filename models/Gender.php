<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "gender".
 *
 * @property int $id
 * @property string $name
 */
class Gender extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gender';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
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
            'name' => '名称',
        ];
    }

    /**
     * @return array
     */
    public static function getGenderList()
    {
        $result = [];
        $list = Gender::find()->all();
        if (!empty($list)) {
            $result = ArrayHelper::map($list, 'id', 'name');
        }
        return $result;
    }
}
