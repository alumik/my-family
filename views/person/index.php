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
                'filter' => \app\models\Person::getFamilyNameList(),
                'headerOptions' => [
                    'width' => '100',
                ],
            ],
            [
                'attribute' => 'full_name',
                'value' => function ($model) {
                    return Html::a($model->full_name, ['person/view', 'id' => $model->id]);
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'birth_date',
                'value' => function($model) {
                    if ($model->inaccurate_birth_date) {
                        return '(不准确)';
                    }
                    return $model->birth_date;
                },
            ],
            'age',
            [
                'attribute' => 'gender',
                'value' => 'gender_name',
                'filter' => \app\models\Gender::getGenderList(),
            ],
            'my_relationship',
            [
                'attribute' => 'alive',
                'value' => 'alive_text',
                'filter' => [
                    '1' => '是',
                    '0' => '否',
                ],
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>
</div>
