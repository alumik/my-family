<?php

/* @var $this yii\web\View */
/* @var $result array */

/* @var $relation_types array */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '称呼计算器';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calc-relation">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="calc-form">

        <?php $form = ActiveForm::begin([
            'options' => [
                'autocomplete' => 'off',
            ],
        ]); ?>

        <?= $form->field($model, 'query', ['template' => '
            {label}
            <div class="input-group">
                <span class="input-group-addon">我</span>
                {input}
            </div>
            {error}
            {hint}'])->textInput(['id' => 'query']) ?>

        <p>注：查询条件需用“的”字进行分割。</p>

        <?= $form->field($model, 'gender', ['enableClientValidation' => false])
            ->inline()
            ->radioList([-1 => '未知', 1 => '男', 0 => '女']); ?>

        <div class="form-group">
            <?php foreach ($relation_types as $k => $v): ?>
                <?= Html::button($v, ['class' => 'btn btn-default', 'onclick' => 'appendRelation(' . $k . ')']); ?>
            <?php endforeach; ?>
            <?= Html::button('删除', ['class' => 'btn btn-danger', 'onclick' => 'deleteRelation()']) ?>
            <?= Html::button('清空', ['class' => 'btn btn-danger', 'onclick' => 'clearRelation()']) ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton('计算', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

        <script type="application/javascript">
            let relation_types = <?= json_encode($relation_types) ?>;

            window.onload = () => {
                $('#query').val('<?= $model->query ?>');
            };

            function appendRelation(relation) {
                let query = $('#query');
                query.val(query.val() + '的' + relation_types[parseInt(relation)]);
            }

            function deleteRelation() {
                let query = $('#query');
                if (query.val()) {
                    query.val(query.val().substring(0, query.val().length - 3));
                }
            }

            function clearRelation() {
                $('#query').val('');
            }
        </script>

        <style type="text/css">
            @media (max-width: 489px) {
                .btn {
                    margin-top: 3px;
                }
            }
        </style>

    </div>

    <div class="calc-result">
        <?php if ($result['error_level'] != -1): ?>
            <?php if ($result['error_level'] == 0): ?>
                <div class="panel panel-default">
            <?php elseif ($result['error_level'] == 1): ?>
                <div class="panel panel-warning">
            <?php else: ?>
                <div class="panel panel-danger">
            <?php endif; ?>
                <div class="panel-heading">
                    <h3 class="panel-title">计算结果</h3>
                </div>
                <div class="panel-body">
                    <p><?= $result['data'] ?></p>
                </div>
            </div>
        <?php endif; ?>
    </div>

</div>
