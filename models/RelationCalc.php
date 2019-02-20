<?php

namespace app\models;

use yii\base\Model;
use yii\helpers\ArrayHelper;

class RelationCalc extends Model
{
    public $base;
    public $target;

    private $base_name;
    private $target_name;
    private $relation = null;

//    public static $order = ['幺', '大', '二', '三', '四', '五', '六', '七', '八', '九', '十'];

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['base', 'target'], 'required'],
            [['base'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['base' => 'id']],
            [['target'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['target' => 'id']],
            ['base', 'compare', 'compareAttribute' => 'target', 'operator' => '!='],
            ['target', 'compare', 'compareAttribute' => 'base', 'operator' => '!='],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'base' => '起点',
            'target' => '终点',
        ];
    }

    /**
     * @return array
     */
    public function getName()
    {
        if (!$this->relation) {
            return [
                'error_level' => 2,
                'data' => '抱歉，关系绕的路太遥远或有错误，无法计算称呼。',
            ];
        }

        switch ($this->relation['gender']) {
            case 2:
                $gender = 1;
                break;
            case 3:
                $gender = 0;
                break;
            default:
                $gender = -1;
        }
        $query = substr($this->relation['result'], 3);
        $names = NameCalc::calculateName(['text' => $query, 'sex' => $gender]);
//        $order = $this->relation['order'];

        if ($names) {
            $error_level = 0;
//            if ($order != -1) {
//                if ($order >= count(self::$order)) {
//                    $order_prefix = $order;
//                } else {
//                    $order_prefix = self::$order[$order];
//                }
//            } else {
//                $order_prefix = '';
//            }
//            foreach ($names as &$name) {
//                $name = $order_prefix . $name;
//            }
            $data = implode('</strong>或<strong>', $names);
            $data = '<strong>' . $this->base_name . '</strong>是<strong>' . $this->target_name . '</strong>的<strong>' . $data . '</strong>。';
        } else {
            $error_level = 2;
            $data = '抱歉，关系绕的路太遥远或有错误，无法计算称呼。';
        }

        return [
            'error_level' => $error_level,
            'data' => $data,
        ];
    }

    /**
     * @return array
     */
    public function getRelation()
    {
        $this->base_name = Person::findOne($this->base)->full_name;
        $this->target_name = Person::findOne($this->target)->full_name;
        $relation = $this->calculateRelation();

        if ($relation) {
            return [
                'error_level' => 0,
                'data' => '<strong>' . $this->base_name . '</strong>是<strong>' . $this->target_name . '</strong>' . $relation . '。',
            ];
        }
        return [
            'error_level' => 1,
            'data' => '抱歉，无法计算<strong>' . $this->base_name . '</strong>与<strong>' . $this->target_name . '</strong>的联系。',
        ];
    }

    /**
     * @return bool|string
     */
    private function calculateRelation()
    {
        $relation_graph = $this->getRelationGraph();
        $shortest_path = $this->getShortestPath($relation_graph);
        $path = $shortest_path['path'];

        if (!$shortest_path['marked']) {
            return false;
        };

        $current = $this->target;
//        $second_last_node = $current;
        $relation = '';

        while ($path[$current]['from']) {
            $relation .= '的' . $path[$current]['type'];
            $current = $path[$current]['from'];

//            if ($path[$current]['from']) {
//                $second_last_node = $current;
//            }
        }

//        if ($path[$second_last_node]['type'] == '丈夫' || $path[$second_last_node]['type'] == '妻子') {
//            $order = RelationCalc::getOrder($second_last_node);
//        } else {
//            $order = RelationCalc::getOrder($this->base);
//        }

        $this->relation = [
            'result' => $relation,
            'gender' => Person::findOne($this->target)->gender,
//            'order' => $order,
        ];

        return $relation;
    }

    /**
     * @return array
     */
    private function getRelationGraph()
    {
        $graph = [];
        $length = [];
        $marked = [];

        $people = Person::find()->all();

        foreach ($people as $person) {
            $graph[$person['id']] = [];
            $length[$person['id']] = INF;
            $marked[$person['id']] = false;
        }

        foreach ($people as $person) {
            $children = $person->children;
            foreach ($children as $child_1) {
                foreach ($children as $child_2) {
                    if ($child_1 != $child_2) {
                        switch ($child_1->gender) {
                            case Gender::$MALE:
                                if ($child_1->birth_date > $child_2->birth_date) {
                                    $type_1_to_2 = '弟弟';
                                } else if ($child_1->birth_date < $child_2->birth_date) {
                                    $type_1_to_2 = '哥哥';
                                } else {
                                    $type_1_to_2 = '兄弟';
                                }
                                break;
                            case Gender::$FEMALE:
                                if ($child_1->birth_date > $child_2->birth_date) {
                                    $type_1_to_2 = '妹妹';
                                } else if ($child_1->birth_date < $child_2->birth_date) {
                                    $type_1_to_2 = '姐姐';
                                } else {
                                    $type_1_to_2 = '姐妹';
                                }
                                break;
                            default:
                                $type_1_to_2 = null;
                        }
                        switch ($child_2->gender) {
                            case Gender::$MALE:
                                if ($child_1->birth_date < $child_2->birth_date) {
                                    $type_2_to_1 = '弟弟';
                                } else if ($child_1->birth_date > $child_2->birth_date) {
                                    $type_2_to_1 = '哥哥';
                                } else {
                                    $type_2_to_1 = '兄弟';
                                }
                                break;
                            case Gender::$FEMALE:
                                if ($child_1->birth_date < $child_2->birth_date) {
                                    $type_2_to_1 = '妹妹';
                                } else if ($child_1->birth_date > $child_2->birth_date) {
                                    $type_2_to_1 = '姐姐';
                                } else {
                                    $type_2_to_1 = '姐妹';
                                }
                                break;
                            default:
                                $type_2_to_1 = null;
                        }
                        if ($type_1_to_2) {
                            $graph[$child_1->id][] = ['id' => $child_2->id, 'type' => $type_1_to_2];
                        }
                        if ($type_2_to_1) {
                            $graph[$child_2->id][] = ['id' => $child_1->id, 'type' => $type_2_to_1];
                        }
                    }
                }
            }
        }

        $relations = Relation::find()->all();

        foreach ($relations as $relation) {
            $parent = Person::findOne($relation->parent);
            $child = Person::findOne($relation->child);

            switch ($relation->type) {
                case RelationType::$QINZI:
                    switch ($parent->gender) {
                        case Gender::$MALE:
                            $type_parent_to_child = '父亲';
                            break;
                        case Gender::$FEMALE:
                            $type_parent_to_child = '母亲';
                            break;
                        default:
                            $type_parent_to_child = '父母';
                    }
                    switch ($child->gender) {
                        case Gender::$MALE:
                            $type_child_to_parent = '儿子';
                            break;
                        case Gender::$FEMALE:
                            $type_child_to_parent = '女儿';
                            break;
                        default:
                            $type_child_to_parent = '子女';
                    }
                    break;
                case RelationType::$FUQI:
                    $type_parent_to_child = '丈夫';
                    $type_child_to_parent = '妻子';
                    break;
                default:
                    $type_parent_to_child = '未知';
                    $type_child_to_parent = '未知';
            }
            $graph[$relation->parent][] = ['id' => $relation->child, 'type' => $type_parent_to_child];
            $graph[$relation->child][] = ['id' => $relation->parent, 'type' => $type_child_to_parent];
        }

        return [
            'graph' => $graph,
            'length' => $length,
            'marked' => $marked,
        ];
    }

    /**
     * @param $relation_graph
     * @return array
     */
    private function getShortestPath($relation_graph)
    {
        $graph = $relation_graph['graph'];
        $length = $relation_graph['length'];
        $marked = $relation_graph['marked'];

        $current = $this->base;
        $marked[$current] = true;
        $path[$current] = ['from' => null, 'type' => null];
        $length[$current] = 0;

        for ($i = 0; $i < 1000; $i++) {
            foreach ($graph[$current] as $node) {
                if (!$marked[$node['id']]) {
                    $dist = $length[$current] + 1;
                    if ($dist < $length[$node['id']]) {
                        $length[$node['id']] = $dist;
                        $path[$node['id']] = ['from' => $current, 'type' => $node['type']];
                    }
                }
            }
            $min_length = INF;
            $min_node = -1;
            foreach ($length as $k => $v) {
                if ($v < $min_length && !$marked[$k]) {
                    $min_length = $v;
                    $min_node = $k;
                }
            }
            if ($min_node == -1) {
                break;
            }
            $current = $min_node;
            $marked[$min_node] = true;
            if ($marked[$this->target]) {
                break;
            }
        }

        return [
            'marked' => $marked[$this->target],
            'path' => $path,
        ];
    }

    /**
     * @param $base
     * @return int
     * @throws \yii\base\InvalidConfigException
     */
    public static function getOrder($base)
    {
        $parents = Person::findOne($base)->getParents()->asArray()->all();
        $parents = ArrayHelper::getColumn($parents, 'id');

        $siblings = Relation::find()
            ->select('child')
            ->leftJoin('person', 'relation.child = person.id')
            ->where([
                'parent' => $parents,
                'type' => RelationType::$QINZI,
                'gender' => Person::findOne($base)->gender,
            ])
            ->groupBy('relation.child')
            ->orderBy('person.birth_date')
            ->asArray()
            ->all();

        if ($siblings && count($siblings) != 1) {
            $siblings = ArrayHelper::getColumn($siblings, 'child');
            $siblings = array_flip($siblings);
            $order = $siblings[$base] + 1;
            if ($order == count($siblings)) {
                $order = 0;
            }
            return $order;
        }

        return -1;
    }
}