<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Person */

$this->title = $model->full_name;
$this->params['breadcrumbs'][] = ['label' => '家庭成员', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->id;
\yii\web\YiiAsset::register($this);
?>
<div class="person-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
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
            'family_name',
            'given_name',
            'birth_date',
            'age',
            [
                'attribute' => 'gender',
                'value' => $model->gender_name,
            ],
            [
                'attribute' => 'alive',
                'value' => $model->alive_text,
            ],
            'my_relationship',
            'phone',
            'description:ntext',
        ],
    ]) ?>

</div>
