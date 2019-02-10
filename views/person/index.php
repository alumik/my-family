<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PersonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '家庭成员';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('添加新成员', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'headerOptions' => [
                    'width' => '80',
                ],
            ],
            [
                'attribute' => 'family_name',
                'headerOptions' => [
                    'width' => '100',
                ],
            ],
            'full_name',
            'birth_date',
            [
                'attribute' => 'gender',
                'value' => 'genderName',
                'filter' => \app\models\Gender::getGenderList(),
            ],
            'my_relationship',
            [
                'attribute' => 'alive',
                'value' => 'aliveText',
                'filter' => [
                    '1' => '是',
                    '0' => '否',
                ],
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
