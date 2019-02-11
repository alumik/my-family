<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "gender".
 *
 * @property int $id
 * @property string $name
 *
 * @property Person[] $people
 */
class Gender extends \yii\db\ActiveRecord
{
    public static $UNKNOWN = 1;
    public static $MALE = 2;
    public static $FEMALE = 3;

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
            'name' => '名称',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeople()
    {
        return $this->hasMany(Person::className(), ['gender' => 'id']);
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
