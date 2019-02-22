<?php

/* @var $this yii\web\View */
/* @var $result array */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\DetailView;

$this->title = '农历阳历互转';
$this->params['breadcrumbs'][] = ['label' => '工具箱', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calc-calendar">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="calc-form">

        <?php $form = ActiveForm::begin([
            'fieldClass' => 'justinvoelker\awesomebootstrapcheckbox\ActiveField',
            'options' => [
                'autocomplete' => 'off',
            ],
        ]); ?>

        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'year', ['template' => '
                    {label}
                    <div class="input-group">
                        {input}
                        <span class="input-group-addon">年</span>
                    </div>
                    {error}
                    {hint}'])->textInput()->label(false) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'month', ['template' => '
                    {label}
                    <div class="input-group">
                        {input}
                        <span class="input-group-addon">月</span>
                    </div>
                    {error}
                    {hint}'])->textInput()->label(false) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'day', ['template' => '
                    {label}
                    <div class="input-group">
                        {input}
                        <span class="input-group-addon">日</span>
                    </div>
                    {error}
                    {hint}'])->textInput()->label(false) ?>
            </div>
        </div>

        <?= $form->field($model, 'type', ['enableClientValidation' => false])
            ->inline()
            ->radioList(['solar' => '阳历', 'lunar' => '农历']); ?>

        <div class="form-group">
            <?= Html::submitButton('计算', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

    <div class="calc-result">
        <?php if ($result['error_level'] == 0): ?>
            <?= DetailView::widget([
                'model' => $result['data'],
                'attributes' => [
                    '阳历日期',
                    '农历日期',
                    '农历日期（干支表示）',
                    '生肖',
                    '节气',
                    '星期',
                    '星座',
                ],
            ]) ?>
        <?php elseif ($result['error_level'] == 1): ?>
            <div class="alert alert-danger">输入的日期有误，请检查。</div>
        <?php endif; ?>
    </div>

</div>
