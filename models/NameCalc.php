<?php

namespace app\models;

use yii\base\Model;

class NameCalc extends Model
{
    public $query_str;
    public $query;

    public function rules()
    {
        return [
            ['query_str', 'compare', 'compareValue' => '我', 'operator' => '!=', 'message' => '查询条件不能为空。'],
            [['query_str', 'query'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'query_str' => '查询条件',
            'query' => '查询数据',
        ];
    }

    /**
     * @return array
     */
    public function calculateName()
    {
        $name = $this->getName();
        if ($name['out'] == 0) {
            $name['name'] = str_replace('%number%', '大/.../幺', $name['name']);
            $name['name'] = str_replace('%order%', '', $name['name']);
            $name['name'] = str_replace('%second_number%', '大/.../幺', $name['name']);
            $name['name'] = str_replace('%second_order%', '', $name['name']);
            $name_str = $this->query_str . '是我的<strong>' . $name['name'] . '</strong>。';
        } else if ($name['out'] == 1) {
            $name_str = '抱歉，关系绕的路太遥远或有错误，无法计算称呼。但是根据辈分可以叫做<strong>' . $name['name'] . '</strong>。';
        } else {
            $name_str = '抱歉，关系绕的路太遥远或有错误，无法计算称呼。';
        }
        return [
            'name_str' => $name_str,
            'out' => $name['out'],
        ];
    }

    /**
     * @return array
     */
    public function getName()
    {
        $queries = [];
        for ($i = 0, $l = strlen($this->query); $i < $l; $i++) {
            $queries[] = intval($this->query[$i]);
        }
        $current_node = 1;
        $generation = 0;
        $gender = 1;
        $out = 0;
        foreach ($queries as $query) {
            if (!$out) {
                $related_node = NameGraph::find()
                    ->select('related_node')
                    ->where(['node' => $current_node, 'type' => $query])
                    ->asArray()
                    ->one();
                if ($related_node) {
                    $current_node = $related_node['related_node'];
                } else {
                    $out = 1;
                }
            }
            $type = NameType::findOne($query);
            $generation += $type->generation;
            $gender = $type->gender;
        }

        if ($out) {
            $name = NameOut::find()
                ->where(['generation' => $generation, 'gender' => $gender])
                ->asArray()
                ->one();
            if (!$name) {
                $out = 2;
            } else {
                $name = $name['name'];
            }
        } else {
            $name = NameNode::findOne($current_node)->name;
        }
        return [
            'out' => $out,
            'name' => $name,
        ];
    }
}