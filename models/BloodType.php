<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "blood_type".
 *
 * @property int $id
 * @property string $name
 */
class BloodType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blood_type';
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
    public static function getBloodTypeList()
    {
        $result = self::find()->all();
        return ArrayHelper::map($result, 'id', 'name');
    }
}
