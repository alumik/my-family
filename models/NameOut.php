<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "name_out".
 *
 * @property int $id
 * @property int $generation
 * @property int $gender
 * @property string $name
 *
 * @property Gender $gender0
 */
class NameOut extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'name_out';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['generation', 'gender', 'name'], 'required'],
            [['generation', 'gender'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['gender'], 'exist', 'skipOnError' => true, 'targetClass' => Gender::className(), 'targetAttribute' => ['gender' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'generation' => 'Generation',
            'gender' => 'Gender',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGender0()
    {
        return $this->hasOne(Gender::className(), ['id' => 'gender']);
    }
}
