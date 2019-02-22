<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PersonSearch represents the model behind the search form of `app\models\Person`.
 */
class PersonSearch extends Person
{
    public $full_name;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'gender', 'alive'], 'integer'],
            [['family_name', 'full_name', 'comment'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Person::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'family_name',
                'full_name' => [
                    'asc' => ['family_name' => SORT_ASC, 'given_name' => SORT_ASC],
                    'desc' => ['family_name' => SORT_DESC, 'given_name' => SORT_DESC],
                    'label' => '姓名',
                    'default' => SORT_ASC,
                ],
                'birth_date',
                'age' => [
                    'asc' => ['alive' => SORT_DESC, 'birth_date' => SORT_DESC],
                    'desc' => ['alive' => SORT_DESC, 'birth_date' => SORT_ASC],
                ],
                'gender',
                'alive',
            ],
            'defaultOrder' => ['id' => SORT_ASC],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'birth_date' => $this->birth_date,
            'gender' => $this->gender,
            'alive' => $this->alive,
        ]);

        $query->andFilterWhere(['like', 'family_name', $this->family_name])
            ->andFilterWhere(['like', 'given_name', $this->given_name])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        $query->andWhere('family_name like "%' . $this->full_name . '%" or given_name like "%' . $this->full_name . '%"');

        return $dataProvider;
    }
}
