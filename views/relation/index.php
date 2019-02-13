<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $search_model app\models\RelationshipSearch */
/* @var $data_provider yii\data\ActiveDataProvider */

$this->title = '家庭关系';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="relationship-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('添加新关系', ['create'], ['class' => 'btn btn-success']) ?>
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
            'parent_name',
            'child_name',
            [
                'attribute' => 'type',
                'value' => 'type_name',
                'filter' => \app\models\RelationType::getRelationTypeList(),
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
