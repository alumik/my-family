<?php

/* @var $this yii\web\View */
/* @var $model app\models\Person */
/* @var $related_people array */

use yii\helpers\Html;
use yii\widgets\DetailView;

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
            [
                'attribute' => 'birth_date',
                'value' => function ($model) {
                    if ($model->inaccurate_birth_date) {
                        return $model->birth_date . ' <span class="not-set">(不准确)</span>';
                    }
                    return $model->birth_date;
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'lunar_birth_date',
                'value' => function ($model) {
                    if (!$model->lunar_birth_date) {
                        return '<span class="not-set">(不可用)</span>';
                    }
                    return $model->lunar_birth_date;
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'age',
                'value' => function ($model) {
                    if ($model->age == -1) {
                        return '<span class="gray-text">(已去世)</span>';
                    } else if ($model->age == -2) {
                        return '';
                    }
                    return $model->age;
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'gender',
                'value' => $model->gender0->name,
            ],
            [
                'attribute' => 'blood_type',
                'value' => $model->blood_type0->name,
            ],
            'id_card',
            'alive:boolean',
            'phone',
            'my_relation',
        ],
    ]) ?>

    <?php foreach ($related_people as $type => $data_provider): ?>
        <?php if ($data_provider): ?>
            <p><strong><?= $type ?></strong></p>
            <?= $this->render('_related_people', ['data_provider' => $data_provider]) ?>
            <br/>
        <?php endif; ?>
    <?php endforeach; ?>

</div>
