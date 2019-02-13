<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Relation */

$this->title = $model->parent_name . ' - ' . $model->child_name;
$this->params['breadcrumbs'][] = ['label' => '家庭关系', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->id;
\yii\web\YiiAsset::register($this);
?>
<div class="relation-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('修改关系', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除关系', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '您确定要删除此项吗？',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'parent_name',
                'value' => Html::a($model->parent_name, ['person/view', 'id' => $model->parent]),
                'format' => 'raw',
            ],
            [
                'attribute' => 'child_name',
                'value' => Html::a($model->child_name, ['person/view', 'id' => $model->child]),
                'format' => 'raw',
            ],
            [
                'attribute' => 'type',
                'value' => $model->type0->name,
            ],
        ],
    ]) ?>

</div>
