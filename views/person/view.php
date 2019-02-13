<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Person */
/* @var $parents \yii\data\ActiveDataProvider */
/* @var $children \yii\data\ActiveDataProvider */
/* @var $wives \yii\data\ActiveDataProvider */
/* @var $husbands \yii\data\ActiveDataProvider */

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
                'value' => function($model) {
                    if ($model->inaccurate_birth_date) {
                        return $model->birth_date . ' <span class="not-set">(不准确)</span>';
                    }
                    return $model->birth_date;
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'lunar_birth_date',
                'format' => 'raw',
            ],
            [
                'attribute' => 'age',
                'format' => 'raw',
            ],
            [
                'attribute' => 'gender',
                'value' => $model->gender_name,
            ],
            [
                'attribute' => 'blood_type',
                'value' => $model->blood_type_name,
            ],
            'id_card',
            'alive:boolean',
            'my_relation',
            'phone',
        ],
    ]) ?>

    <?php if ($parents): ?>
        <p><strong>父母</strong></p>
        <?= $this->render('_related_people', ['data_provider' => $parents]) ?>
        <br/>
    <?php endif; ?>

    <?php if ($children): ?>
        <p><strong>子女</strong></p>
        <?= $this->render('_related_people', ['data_provider' => $children]) ?>
        <br/>
    <?php endif; ?>

    <?php if ($husbands): ?>
        <p><strong>丈夫</strong></p>
        <?= $this->render('_related_people', ['data_provider' => $husbands]) ?>
        <br/>
    <?php endif; ?>

    <?php if ($wives): ?>
        <p><strong>妻子</strong></p>
        <?= $this->render('_related_people', ['data_provider' => $wives]) ?>
        <br/>
    <?php endif; ?>

</div>
