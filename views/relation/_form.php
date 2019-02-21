<?php

/* @var $this yii\web\View */
/* @var $model app\models\Relation */
/* @var $form yii\widgets\ActiveForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
?>
<div class="relation-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'parent')->widget(Select2::classname(), [
                'bsVersion' => '3.x',
                'data' => \app\models\Person::getPersonList(),
                'options' => ['placeholder' => '请选择'],
            ]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'child')->widget(Select2::classname(), [
                'bsVersion' => '3.x',
                'data' => \app\models\Person::getPersonList(),
                'options' => ['placeholder' => '请选择'],
            ]) ?>
        </div>
    </div>

    <?= $form->field($model, 'type')->widget(Select2::classname(), [
        'hideSearch' => true,
        'bsVersion' => '3.x',
        'data' => \app\models\RelationType::getRelationTypeList(),
        'options' => ['placeholder' => '请选择'],
    ]) ?>

    <p>注：名字后方括号内的数字是对应成员的编号。</p>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
