<?php

/* @var $this yii\web\View */
/* @var $model app\models\Person */
/* @var $form yii\widgets\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
?>

<div class="person-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'autocomplete' => 'off',
        ],
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'family_name')->textInput(['maxlength' => true])->label('姓氏') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'given_name')->textInput(['maxlength' => true])->label('名字') ?>
        </div>
    </div>

    <?= $form->field($model, 'birth_date')->widget(\nex\datepicker\DatePicker::className(), [
        'language' => 'zh-CN',
        'clientOptions' => [
            'format' => 'YYYY-MM-DD',
            'stepping' => 30,
        ],
    ]) ?>

    <?= $form->field($model, 'inaccurate_birth_date', ['enableClientValidation' => false])->inline()->checkbox() ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'gender')->widget(Select2::classname(), [
                'hideSearch' => true,
                'bsVersion' => '3.x',
                'data' => \app\models\Gender::getGenderList(),
            ]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'blood_type')->widget(Select2::classname(), [
                'hideSearch' => true,
                'bsVersion' => '3.x',
                'data' => \app\models\BloodType::getBloodTypeList(),
            ]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'alive')->widget(Select2::classname(), [
                'hideSearch' => true,
                'bsVersion' => '3.x',
                'data' => [1 => '是', 0 => '否'],
            ]) ?>
        </div>
    </div>

    <?= $form->field($model, 'id_card')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'my_relation')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
