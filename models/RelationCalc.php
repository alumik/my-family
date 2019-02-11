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
            [['base', 'target'], 'required' ],
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
        $base_person = Person::findOne($this->base);
        $target_person = Person::findOne($this->target);

        $relation_graph = [];
        $cost = [];
        $path = [];
        $mark = [];

        $all_person = Person::find()->all();
        foreach ($all_person as $person) {
            $relation_graph[$person['id']] = [];
            $cost[$person['id']] = INF;
            $mark[$person['id']] = false;
        }
        foreach ($all_person as $person) {
            $children = $person->children;
            foreach ($children as $cld_a) {
                foreach ($children as $cld_b) {
                    if ($cld_a != $cld_b) {
                        $type_1 = null;
                        $type_2 = null;
                        switch ($cld_a->gender) {
                            case Gender::$MALE:
                                $type_1 = '兄弟';
                                break;
                            case Gender::$FEMALE:
                                $type_1 = '姐妹';
                                break;
                        }
                        switch ($cld_b->gender) {
                            case Gender::$MALE:
                                $type_2 = '兄弟';
                                break;
                            case Gender::$FEMALE:
                                $type_2 = '姐妹';
                                break;
                        }
                        if ($type_1) {
                            array_push($relation_graph[$cld_a->id], [$cld_b->id, $type_1]);
                        }
                        if ($type_2) {
                            array_push($relation_graph[$cld_b->id], [$cld_a->id, $type_2]);
                        }
                    }
                }
            }
        }

        $all_relations = Relationship::find()->asArray()->all();
        foreach ($all_relations as $relation) {
            $parent = Person::findOne($relation['parent']);
            $child = Person::findOne($relation['child']);
            $type_1 = '未知';
            $type_2 = '未知';
            switch ($relation['type']) {
                case RelationType::$QINZI:
                    switch ($parent->gender) {
                        case Gender::$MALE:
                            $type_1 = '父亲';
                            break;
                        case Gender::$FEMALE:
                            $type_1 = '母亲';
                            break;
                        default:
                            $type_1 = '父母';
                    }
                    switch ($child->gender) {
                        case Gender::$MALE:
                            $type_2 = '儿子';
                            break;
                        case Gender::$FEMALE:
                            $type_2 = '女儿';
                            break;
                        default:
                            $type_2 = '子女';
                    }
                    break;
                case RelationType::$PEIOU:
                    $type_1 = '丈夫';
                    $type_2 = '妻子';
                    break;
            }
            array_push($relation_graph[$relation['parent']], [$relation['child'], $type_1]);
            array_push($relation_graph[$relation['child']], [$relation['parent'], $type_2]);
        }

        $current = $this->base;
        $mark[$current] = true;
        $path[$current] = [null, null];
        $cost[$current] = 0;
        $counter = 0;

        while (true) {
            $counter++;

            foreach ($relation_graph[$current] as $node) {
                if (!$mark[$node[0]]) {
                    $dist = 1 + $cost[$current];
                    if ($dist < $cost[$node[0]]) {
                        $cost[$node[0]] = $dist;
                        $path[$node[0]] = [$current, $node[1]];
                    }
                }
            }

            $min_v = INF;
            $min_k = -1;
            foreach ($cost as $k => $v) {
                if ($v < $min_v && !$mark[$k]) {
                    $min_k = $k;
                    $min_v = $v;
                }
            }
            $current = $min_k;
            $mark[$min_k] = true;
            if ($mark[$this->target]) {
                break;
            }
            if ($counter > 1000) {
                break;
            }
        }

        if ($cost[$this->target] == INF) {
            return $base_person->full_name . ' 与 ' . $target_person->full_name . ' 没有联系。';
        };

        $result = $base_person->full_name . ' 是 ' . $target_person->full_name . ' ';
        $current = $this->target;
        while ($path[$current][0]) {
            $result .= '的' . $path[$current][1];
            $current = $path[$current][0];
        }
        return $result . '。';
    }
}