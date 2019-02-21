<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "person".
 *
 * @property int $id
 * @property string $family_name
 * @property string $given_name
 * @property string $birth_date
 * @property int $inaccurate_birth_date
 * @property int $gender
 * @property int $blood_type
 * @property string $id_card
 * @property int $alive
 * @property string $my_relation
 * @property string $phone
 *
 * @property string $full_name
 * @property string $lunar_birth_date
 * @property int $age
 *
 * @property BloodType $blood_type0
 * @property Gender $gender0
 * @property Person[] $children
 * @property Person[] $parents
 * @property Person[] $wives
 * @property Person[] $husbands
 */
class Person extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'person';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['birth_date', 'inaccurate_birth_date', 'gender', 'blood_type', 'alive'], 'required'],
            [['birth_date'], 'safe'],
            [['inaccurate_birth_date', 'gender', 'blood_type', 'alive'], 'integer'],
            [['family_name', 'given_name'], 'string', 'max' => 10],
            [['id_card'], 'string', 'max' => 18],
            [['my_relation'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
            [['gender'], 'exist', 'skipOnError' => true, 'targetClass' => Gender::className(), 'targetAttribute' => ['gender' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'family_name' => '姓',
            'given_name' => '名',
            'birth_date' => '出生日期',
            'inaccurate_birth_date' => '出生日期不准确',
            'gender' => '性别',
            'blood_type' => 'ABO血型',
            'id_card' => '身份证号码',
            'alive' => '是否健在',
            'my_relation' => '与我的关系',
            'phone' => '电话号码',

            'full_name' => '姓名',
            'lunar_birth_date' => '出生日期（农历）',
            'age' => '年龄',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function fields()
    {
        return [
            'id',
            'family_name',
            'given_name',
            'birth_date',
            'lunar_birth_date',
            'age',
            'gender' => function ($model) {
                return $model->gender0->name;
            },
            'blood_type' => function ($model) {
                return $model->blood_type0->name;
            },
            'id_card',
            'alive' => function ($model) {
                return $model->alive ? '是' : '否';
            },
            'my_relation',
            'phone',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function extraFields()
    {
        return ['parents', 'children', 'husbands', 'wives'];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlood_type0()
    {
        return $this->hasOne(BloodType::className(), ['id' => 'blood_type']);
    }

    /**
     * @return string
     */
    public function getFull_name()
    {
        return $this->family_name . $this->given_name;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGender0()
    {
        return $this->hasOne(Gender::className(), ['id' => 'gender']);
    }

    /**
     * @return string|integer
     */
    public function getAge()
    {
        if (!$this->alive) {
            return -1;
        }
        if ($this->birth_date && !$this->inaccurate_birth_date) {
            list($year, $month, $day) = explode('-', $this->birth_date);
            $this_month = date('m');
            $this_day = date('d');
            $age = date('Y') - $year - 1;
            if ($this_month > $month || $this_month == $month && $this_day > $day) {
                $age++;
            }
            return $age;
        }
        return -2;
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getChildren()
    {
        return $this->hasMany(Person::className(), ['id' => 'child'])
            ->viaTable(
                'relation', ['parent' => 'id'],
                function ($query) {
                    $query->onCondition(['type' => RelationType::$QINZI]);
                }
            );
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getParents()
    {
        return $this->hasMany(Person::className(), ['id' => 'parent'])
            ->viaTable(
                'relation', ['child' => 'id'],
                function ($query) {
                    $query->onCondition(['type' => RelationType::$QINZI]);
                }
            );
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getWives()
    {
        return $this->hasMany(Person::className(), ['id' => 'child'])
            ->viaTable(
                'relation', ['parent' => 'id'],
                function ($query) {
                    $query->onCondition(['type' => RelationType::$FUQI]);
                }
            );
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getHusbands()
    {
        return $this->hasMany(Person::className(), ['id' => 'parent'])
            ->viaTable(
                'relation', ['child' => 'id'],
                function ($query) {
                    $query->onCondition(['type' => RelationType::$FUQI]);
                }
            );
    }

    /**
     * @return array
     */
    public static function getPersonList()
    {
        $list = [];
        $result = Person::find()
            ->select(['id', "concat(family_name, given_name, ' [' , id, ']') as full_name"])
            ->orderBy('family_name asc, given_name asc')
            ->asArray()
            ->all();
        if (!empty($result)) {
            $list = ArrayHelper::map($result, 'id', 'full_name');
        }
        return $list;
    }

    /**
     * @return array
     */
    public static function getFamilyNameList()
    {
        $result = [];
        $list = Person::find()
            ->select('family_name')
            ->groupBy('family_name')
            ->orderBy('family_name')
            ->asArray()
            ->all();
        if (!empty($list)) {
            foreach ($list as $item) {
                $result[$item['family_name']] = $item['family_name'];
            }
        }
        return $result;
    }

    /**
     * @return integer
     */
    public static function getPeopleCount()
    {
        return Person::find()->count();
    }

    /**
     * @return string
     */
    public function getLunar_birth_date()
    {
        if ($this->birth_date && !$this->inaccurate_birth_date) {
            $calendar = new \Overtrue\ChineseCalendar\Calendar();
            list($year, $month, $day) = explode('-', $this->birth_date);
            $date = $calendar->solar(intval($year), intval($month), intval($day));
            return $date['ganzhi_year'] . $date['animal'] . '年' . $date['lunar_month_chinese'] . $date['lunar_day_chinese'];
        }
        return false;
    }
}
