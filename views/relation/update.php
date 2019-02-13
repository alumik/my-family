<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Relation */

$this->title = '修改关系: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => '家庭关系', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '修改关系';
?>
<div class="relation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
