<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $relation_result string */
/* @var $name_result string */

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

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    关系
                </h3>
            </div>
            <div class="panel-body">
                <p><?= $relation_result ?></p>
            </div>
        </div>
        <?php if ($name_result): ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        称呼
                    </h3>
                </div>
                <div class="panel-body">
                    <p><?= $name_result ?></p>
                </div>
            </div>
        <?php else: ?>
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        称呼
                    </h3>
                </div>
                <div class="panel-body">
                    <p>无法计算称呼。</p>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>
