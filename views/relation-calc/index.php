<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $result string */

$this->title = '关系计算器';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="relation-calc-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="relation-calc-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'base')->dropDownList(\app\models\Person::getPersonList(), ['prompt' => '请选择']) ?>

        <?= $form->field($model, 'target')->dropDownList(\app\models\Person::getPersonList(), ['prompt' => '请选择']) ?>

        <div class="form-group">
            <?= Html::submitButton('计算', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

    <div class="relation-calc-result">

        <div class="alert alert-info">
            <?= nl2br(Html::encode($result)) ?>
        </div>

    </div>
</div>
