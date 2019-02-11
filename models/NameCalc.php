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
            return $this->query_str . ' 是我的 ' . $name . '。';
        }
        return false;
    }

    /**
     * @return string|boolean
     */
    public function getName() {
        return false;
    }
}