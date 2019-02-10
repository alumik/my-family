<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Relationship */

$this->title = 'Create Relationship';
$this->params['breadcrumbs'][] = ['label' => 'Relationships', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="relationship-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
