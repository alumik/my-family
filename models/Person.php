<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * This is the model class for table "person".
 *
 * @property int $id
 * @property string $family_name
 * @property string $given_name
 * @property string $birth_date
 * @property string $full_name
 * @property int $gender
 * @property int $alive
 * @property string $my_relationship
 * @property string $phone
 * @property string $description
 *
 * @property Gender $gender0
 * @property Relationship[] $relationships
 * @property Relationship[] $relationships0
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
            [['birth_date'], 'safe'],
            [['gender', 'alive'], 'required'],
            [['gender', 'alive'], 'integer'],
            [['description'], 'string'],
            [['family_name', 'given_name'], 'string', 'max' => 10],
            [['my_relationship'], 'string', 'max' => 255],
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
            'full_name' => '姓名',
            'birth_date' => '出生日期',
            'lunar_birth_date' => '出生日期（农历）',
            'age' => '年龄',
            'gender' => '性别',
            'gender_name' => '性别',
            'alive' => '是否健在',
            'alive_text' => '是否健在',
            'my_relationship' => '与我的关系',
            'phone' => '电话号码',
            'description' => '备注',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelationships()
    {
        return $this->hasMany(Relationship::className(), ['parent' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelationships0()
    {
        return $this->hasMany(Relationship::className(), ['child' => 'id']);
    }

    /**
     * @return string
     */
    public function getFull_name()
    {
        return $this->family_name . $this->given_name;
    }

    /**
     * @return string
     */
    public function getAlive_text()
    {
        return $this->alive == 1 ? '是' : '否';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGender0()
    {
        return $this->hasOne(Gender::className(), ['id' => 'gender']);
    }

    /**
     * @return string
     */
    public function getGender_name()
    {
        return $this->gender0->name;
    }

    /**
     * @return string|integer
     */
    public function getAge()
    {
        if ($this->alive == 0) {
            return '-';
        }
        if ($this->birth_date) {
            $birth_date = $this->birth_date;
            list($birth_year, $birth_month, $birth_day) = explode('-', $birth_date);
            $cm = date('n');
            $cd = date('j');
            $age = date('Y') - $birth_year - 1;
            if ($cm > $birth_month || $cm == $birth_month && $cd > $birth_day) $age++;
            return $age;
        }
        return '';
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getChildren()
    {
        return $this->hasMany(Person::className(), ['id' => 'child'])
            ->viaTable(
                'relationship', ['parent' => 'id'],
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
                'relationship', ['child' => 'id'],
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
                'relationship', ['parent' => 'id'],
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
                'relationship', ['child' => 'id'],
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
        $result = [];
        $list = Person::find()
            ->select(['id', 'CONCAT(family_name, given_name) as full_name'])
            ->orderBy('family_name asc, given_name asc')
            ->asArray()
            ->all();
        if (!empty($list)) {
            $result = ArrayHelper::map($list, 'id', 'full_name');
        }
        return $result;
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
     * @param $dataprovider
     * @return string
     * @throws \Exception
     */
    public static function RelationView($dataprovider)
    {
        return \yii\grid\GridView::widget([
            'dataProvider' => $dataprovider,
            'showOnEmpty' => false,
            'emptyText' => '没有相关记录。',
            'columns' => [
                [
                    'attribute' => 'id',
                    'headerOptions' => [
                        'width' => '80',
                    ],
                ],
                [
                    'attribute' => 'full_name',
                    'value' => function ($item) {
                        return Html::a($item->full_name, ['person/view', 'id' => $item->id]);
                    },
                    'format' => 'raw',
                ],
                'birth_date',
                'age',
                'gender_name',
                'my_relationship',
                'alive_text',
            ],
        ]);
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
        if ($this->birth_date) {
            $calendar = new \Overtrue\ChineseCalendar\Calendar();
            $date_str = explode('-', $this->birth_date);
            $date = $calendar->solar(intval($date_str[0]), intval($date_str[1]), intval($date_str[2]));
            return $date['ganzhi_year'] . $date['animal'] . '年' . $date['lunar_month_chinese'] . $date['lunar_day_chinese'];
        }
        return '';
    }
}
