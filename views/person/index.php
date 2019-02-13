<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $search_model app\models\PersonSearch */
/* @var $data_provider yii\data\ActiveDataProvider */

$this->title = '家庭成员';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('添加新成员', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'layout' => "{summary}\n<div class=\"table-wrapper\">\n{items}\n</div>\n{pager}",
        'dataProvider' => $data_provider,
        'filterModel' => $search_model,
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
                        return '<span class="not-set">(不准确)</span>';
                    }
                    return $model->birth_date;
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'age',
                'format' => 'raw',
            ],
            [
                'attribute' => 'gender',
                'value' => 'gender_name',
                'filter' => \app\models\Gender::getGenderList(),
            ],
            'my_relation',
            [
                'attribute' => 'alive',
                'format' => 'boolean',
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
