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
     * @return string
     */
    public function calculateName()
    {
        $name = $this->getName();
        if ($name) {
            $name = str_replace('%number%', '大/.../幺', $name);
            $name = str_replace('%order%', '', $name);
            $name = str_replace('%second_number%', '大/.../幺', $name);
            $name = str_replace('%second_order%', '', $name);
            return $this->query_str . ' 是我的 ' . $name . '。';
        }
        return false;
    }

    /**
     * @return string|boolean
     */
    public function getName()
    {
        $queries = [];
        for ($i = 0, $l = strlen($this->query); $i < $l; $i++) {
            $queries[] = intval($this->query[$i]);
        }
        $current_node = 1;
        foreach ($queries as $query) {
            $related_node = NameGraph::find()
                ->select('related_node')
                ->where(['node' => $current_node, 'type' => $query])
                ->asArray()
                ->one();
            if ($related_node) {
                $current_node = $related_node['related_node'];
            } else {
                return false;
            }
        }
        return NameNode::findOne($current_node)->name;
    }
}