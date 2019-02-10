<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Relationship */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="relationship-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'parent')->dropDownList(\app\models\Person::getPersonList(), ['prompt' => '请选择']) ?>

    <?= $form->field($model, 'child')->dropDownList(\app\models\Person::getPersonList(), ['prompt' => '请选择']) ?>

    <?= $form->field($model, 'type')->dropDownList(\app\models\RelationType::getRelationTypeList(), ['prompt' => '请选择']) ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
