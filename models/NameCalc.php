<?php

namespace app\models;

use yii\base\Model;

class NameCalc extends Model
{
    public $query;
    public $query_code;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['query', 'compare', 'compareValue' => '我', 'operator' => '!=', 'message' => '查询条件不能为空。'],
            [['query', 'query_code'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'query' => '查询条件',
            'query_code' => '查询代码',
        ];
    }

    /**
     * @param $order
     * @param $empty
     * @param $name
     * @return mixed
     */
    public static function replaceOrder($order, $empty, $name)
    {
        $name = str_replace('%number%', $order, $name);
        $name = str_replace('%order%', $empty, $name);
        $name = str_replace('%second_number%', $order, $name);
        $name = str_replace('%second_order%', $empty, $name);
        return $name;
    }

    /**
     * @return array
     */
    public function getName()
    {
        $name = $this->calculateName();

        switch ($name['error_level']) {
            case 0:
                $data = self::replaceOrder('大/.../幺', '', $name['data']);
                $data = $this->query . '是我的<strong>' . $data . '</strong>。';
                break;
            case 1:
                $data = '抱歉，关系绕的路太遥远或有错误，无法计算称呼。但是根据辈分可以叫做<strong>' . $name['data'] . '</strong>。';
                break;
            default:
                $data = '抱歉，关系绕的路太遥远或有错误，无法计算称呼。';
        }

        return [
            'error_level' => $name['error_level'],
            'data' => $data,
        ];
    }

    /**
     * @return array
     */
    public function calculateName()
    {
        if (!$this->query_code) {
            return [
                'error_level' => 2,
                'data' => null,
            ];
        }

        $queries = [];
        $query_length = strlen($this->query_code);
        for ($i = 0; $i < $query_length; $i++) {
            $queries[] = intval($this->query_code[$i]);
        }
        $current_node = 1;
        $generation = 0;
        $gender = 1;
        $error_level = 0;

        foreach ($queries as $query) {
            if ($error_level == 0) {
                $node = NameNode::findOne($current_node);
                $name_graph = $node->getNameGraph($query);
                if ($name_graph) {
                    $current_node = $name_graph->related_node;
                } else {
                    $error_level = 1;
                }
            }
            $name_type = NameType::findOne($query);
            $generation += $name_type->generation;
            $gender = $name_type->gender;
        }

        $data = '';
        if ($error_level) {
            $name_out = NameOut::findOne(['generation' => $generation, 'gender' => $gender]);
            if (!$name_out) {
                $error_level = 2;
            } else {
                $data = $name_out->name;
            }
        } else {
            $data = NameNode::findOne($current_node)->name;
        }

        return [
            'error_level' => $error_level,
            'data' => $data,
        ];
    }
}