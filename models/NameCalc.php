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
            [['query_str', 'query'], 'required'],
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
        // TODO: 完成称呼计算
        return $this->query_str . ' ' . $this->query;
    }
}