<?php

/* @var $this yii\web\View */
/* @var $model app\models\Relation */

use yii\helpers\Html;

$this->title = '添加新关系';
$this->params['breadcrumbs'][] = ['label' => '家庭关系', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="relation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
