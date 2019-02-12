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
                        return $model->birth_date . ' (不准确)';
                    }
                    return $model->birth_date;
                },
            ],
            'lunar_birth_date',
            'age',
            [
                'attribute' => 'gender',
                'value' => $model->gender_name,
            ],
            'alive:boolean',
            'my_relationship',
            'phone',
            'description:ntext',
        ],
    ]) ?>

    <?php if ($parents): ?>
        <p><strong>父母</strong></p>
        <div class="scrollable">
            <?= \app\models\Person::RelationView($parents) ?>
        </div>
        <br/>
    <?php endif; ?>

    <?php if ($children): ?>
        <p><strong>子女</strong></p>
        <div class="scrollable">
            <?= \app\models\Person::RelationView($children) ?>
        </div>
        <br/>
    <?php endif; ?>

    <?php if ($husbands): ?>
        <p><strong>丈夫</strong></p>
        <div class="scrollable">
            <?= \app\models\Person::RelationView($husbands) ?>
        </div>
        <br/>
    <?php endif; ?>

    <?php if ($wives): ?>
        <p><strong>妻子</strong></p>
        <div class="scrollable">
            <?= \app\models\Person::RelationView($wives) ?>
        </div>
        <br/>
    <?php endif; ?>

</div>
