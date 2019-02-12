<?php

namespace app\models;

use app\models\Person;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class RelationCalc extends Model
{
    public $base;
    public $target;
    private $base_person;
    private $target_person;
    private $name_query = '';
    private $order = -1;

    public static $ORDER = ['幺', '大', '二', '三', '四', '五', '六', '七', '八', '九', '十',];

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

    public function calculateName()
    {
        if (!$this->name_query) {
            return false;
        }
        $name_calc = new NameCalc();
        $name_calc->query = $this->name_query;
        $name = $name_calc->getName();
        if ($name) {
            if ($this->order == -1) {
                $order_str = '大/.../幺';
            } else {
                $order_str = RelationCalc::$ORDER[$this->order];
            }
            $name = str_replace('%number%', $order_str, $name);
            $name = str_replace('%order%', $order_str, $name);
            return $this->base_person . ' 是 ' . $this->target_person . ' 的 ' . $name . '。';
        }
        return false;
    }

    /**
     * @return string
     */
    public function calculateRelationship()
    {
        $this->base_person = Person::findOne($this->base)->full_name;
        $this->target_person = Person::findOne($this->target)->full_name;

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
                case RelationType::$FUQI:
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
            return $this->base_person . ' 与 ' . $this->target_person . ' 没有联系。';
        };

        $result = $this->base_person . ' 是 ' . $this->target_person . ' ';
        $current = $this->target;

        $base_gender = Person::findOne($this->base)->gender;

        $parents = Relationship::find()
            ->select('parent')
            ->where(['child' => $this->base, 'type' => RelationType::$QINZI])
            ->asArray()
            ->aLL();
        $parents = ArrayHelper::getColumn($parents, 'parent');

        $siblings = Relationship::find()
            ->select('child')
            ->leftJoin('person', 'relationship.child = person.id')
            ->where(['parent' => $parents, 'type' => RelationType::$QINZI, 'gender' => $base_gender])
            ->groupBy('relationship.child')
            ->orderBy('person.birth_date')
            ->asArray()
            ->all();

        if ($siblings && count($siblings) != 1) {
            $siblings = ArrayHelper::getColumn($siblings, 'child');
            $siblings = array_flip($siblings);
            $this->order = $siblings[$this->base] + 1;
            if ($this->order == count($siblings)) {
                $this->order = 0;
            }
        }

        while ($path[$current][0]) {
            if ($this->name_query != -1) {
                $name_type = NameType::findOne(['name' => $path[$current][1]]);
                if ($name_type) {
                    $this->name_query .= $name_type->id;
                } else {
                    $this->name_query = -1;
                }
            }

            $result .= '的' . $path[$current][1];
            $current = $path[$current][0];
        }
        return $result . '。';
    }
}