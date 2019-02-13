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
     * @return array
     */
    public static function getGenderList()
    {
        $result = Gender::find()->all();
        return ArrayHelper::map($result, 'id', 'name');
    }
}
