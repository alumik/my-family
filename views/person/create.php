<?php

/* @var $this yii\web\View */
/* @var $model app\models\Person */

use yii\helpers\Html;

$this->title = '添加新成员';
$this->params['breadcrumbs'][] = ['label' => '家庭成员', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
