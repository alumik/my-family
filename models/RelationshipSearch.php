<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Relationship;

/**
 * RelationshipSearch represents the model behind the search form of `app\models\Relationship`.
 */
class RelationshipSearch extends Relationship
{
    public $parent_name;
    public $child_name;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'parent', 'child'], 'integer'],
            [['parent_name', 'child_name'], 'safe'],
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
        $query = Relationship::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'parent_name' => [
                    'asc' => ['a.family_name' => SORT_ASC, 'a.given_name' => SORT_ASC],
                    'desc' => ['a.family_name' => SORT_DESC, 'a.given_name' => SORT_DESC],
                    'label' => '父/母姓名',
                    'default' => SORT_ASC,
                ],
                'child_name' => [
                    'asc' => ['b.family_name' => SORT_ASC, 'b.given_name' => SORT_ASC],
                    'desc' => ['b.family_name' => SORT_DESC, 'b.given_name' => SORT_DESC],
                    'label' => '子/女姓名',
                    'default' => SORT_ASC,
                ],
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
            'parent' => $this->parent,
            'child' => $this->child,
        ]);

        $query->join('LEFT JOIN', 'person as a', 'relationship.parent = a.id');
        $query->join('LEFT JOIN', 'person as b', 'relationship.child = b.id');
        $query->andWhere('a.family_name LIKE "%' . $this->parent_name . '%" OR a.given_name LIKE "%' . $this->parent_name . '%"');
        $query->andWhere('b.family_name LIKE "%' . $this->child_name . '%" OR b.given_name LIKE "%' . $this->child_name . '%"');

        return $dataProvider;
    }
}
