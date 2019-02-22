<?php

namespace app\models;

use yii\base\Model;
use Overtrue\ChineseCalendar\Calendar;

/**
 * Class CalendarCalc
 * @package app\models
 */
class CalendarCalc extends Model
{
    public $year;
    public $month;
    public $day;
    public $type;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['year', 'month', 'day', 'type'], 'required'],
            ['year', 'integer', 'min' => 1900, 'max' => 2100],
            ['month', 'integer', 'min' => 1, 'max' => 12],
            ['day', 'integer', 'min' => 1, 'max' => 31],
            ['type', 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'year' => '年',
            'month' => '月',
            'day' => '日',
            'type' => '输入类型',
        ];
    }

    /**
     * @return array
     */
    public function getDateData()
    {
        $calendar = new Calendar();
        $error_level = 0;

        try {
            if ($this->type == 'lunar') {
                $data = $calendar->lunar(intval($this->year), intval($this->month), intval($this->day));
            } else {
                $data = $calendar->solar(intval($this->year), intval($this->month), intval($this->day));
            }
        } catch (\Exception $e) {
            $data = null;
            $error_level = 1;
        }

        if ($error_level == 0) {
            $processed_data = [];
            $processed_data['阳历日期'] = $data['gregorian_year'] . '年' . $data['gregorian_month'] . '月' . $data['gregorian_day'] . '日';
            $processed_data['农历日期'] = $data['lunar_year_chinese'] . '年' . $data['lunar_month_chinese'] . $data['lunar_day_chinese'];
            $processed_data['农历日期（干支表示）'] = $data['ganzhi_year'] . '年' . $data['ganzhi_month'] . '月' . $data['ganzhi_day'] . '日';
            $processed_data['生肖'] = $data['animal'];
            $processed_data['节气'] = $data['term'] ? $data['term'] : '无';
            $processed_data['星期'] = $data['week_name'];
            $processed_data['星座'] = $data['constellation'] . '座';
            $data = $processed_data;
        }

        return [
            'error_level' => $error_level,
            'data' => $data,
        ];
    }
}