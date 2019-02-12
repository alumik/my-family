<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Person */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="person-form">

    <?php $form = ActiveForm::begin(
        [
            'options' => [
                'autocomplete' => 'off',
            ],
        ]
    ); ?>

    <?= $form->field($model, 'family_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'given_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'birth_date')->widget(\nex\datepicker\DatePicker::className(), [
        'language' => 'zh-CN',
        'clientOptions' => [
            'format' => 'YYYY-MM-DD',
            'stepping' => 30,
        ],
    ]) ?>

    <?= $form->field($model, 'inaccurate_birth_date')->checkbox() ?>

    <?= $form->field($model, 'gender')->dropDownList(\app\models\Gender::getGenderList(), ['prompt' => '请选择']) ?>

    <?= $form->field($model, 'blood_type')->dropDownList(\app\models\BloodType::getBloodTypeList(), ['prompt' => '请选择']) ?>

    <?= $form->field($model, 'id_card')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alive')->dropDownList([1 => '是', 0 => '否'], ['prompt' => '请选择']) ?>

    <?= $form->field($model, 'my_relationship')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
