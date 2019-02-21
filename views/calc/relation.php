<?php

/* @var $this yii\web\View */
/* @var $relation_result array */

/* @var $name_result array */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

$this->title = '关系计算器';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="relation-calc-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="relation-calc-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'base')->widget(Select2::classname(), [
            'bsVersion' => '3.x',
            'data' => \app\models\Person::getPersonList(),
            'options' => ['placeholder' => '请选择'],
        ]) ?>

        <?= $form->field($model, 'target')->widget(Select2::classname(), [
            'bsVersion' => '3.x',
            'data' => \app\models\Person::getPersonList(),
            'options' => ['placeholder' => '请选择'],
        ]) ?>

        <p>注：名字后方括号内的数字是对应成员的编号。</p>

        <div class="form-group">
            <?= Html::submitButton('计算', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

    <div class="relation-calc-result">

        <?php if ($relation_result['error_level'] != -1): ?>
            <?php if ($relation_result['error_level'] == 0): ?>
                <div class="panel panel-default">
            <?php else: ?>
                <div class="panel panel-danger">
            <?php endif; ?>
                <div class="panel-heading">
                    <h3 class="panel-title">关系</h3>
                </div>
                <div class="panel-body">
                    <p><?= $relation_result['data'] ?></p>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($name_result['error_level'] != -1): ?>
            <?php if ($name_result['error_level'] == 0): ?>
                <div class="panel panel-default">
            <?php elseif ($name_result['error_level'] == 1): ?>
                <div class="panel panel-warning">
            <?php else: ?>
                <div class="panel panel-danger">
            <?php endif; ?>
                <div class="panel-heading">
                    <h3 class="panel-title">称呼</h3>
                </div>
                <div class="panel-body">
                    <p><?= $name_result['data'] ?></p>
                </div>
            </div>
        <?php endif; ?>

    </div>

</div>
