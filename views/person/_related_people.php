<?php

/* @var $this yii\web\View */
/* @var $data_provider \yii\data\ActiveDataProvider */

use \yii\helpers\Html;
use \yii\grid\GridView;
?>

<?= GridView::widget([
    'layout' => "{summary}\n<div class=\"table-wrapper\">\n{items}\n</div>\n{pager}",
    'dataProvider' => $data_provider,
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
        [
            'attribute' => 'age',
            'format' => 'raw',
        ],
        [
            'attribute' => 'gender',
            'value' => 'gender0.name',
        ],
        'my_relation',
        'alive:boolean',
    ],
]); ?>
