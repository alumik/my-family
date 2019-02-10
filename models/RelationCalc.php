<?php

namespace app\models;

use app\models\Person;
use yii\base\Model;

class RelationCalc extends Model
{
    public $base;
    public $target;

    public function rules()
    {
        return [
            [['base'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['base' => 'id']],
            [['target'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['target' => 'id']],
            ['base', 'compare', 'compareAttribute' => 'target', 'operator' => '!='],
            ['target', 'compare', 'compareAttribute' => 'base', 'operator' => '!='],
        ];
    }

    public function attributeLabels()
    {
        return [
            'base' => '起点',
            'target' => '终点',
        ];
    }

    /**
     * @return string
     */
    public function calculateRelationship()
    {
//        $base_person = Person::findOne($this->base);
//        $target_person = Person::findOne($this->target);
//
//        $relation_graph = [];
//        $all_person = Person::find()->asArray()->all();
//        foreach ($all_person as $person) {
//            $relation_graph
//        }

        return '关系明了。';
    }
}