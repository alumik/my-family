<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $result string */

$this->title = '称呼计算器';
$this->params['breadcrumbs'][] = $this->title;

$relations = ['父亲', '母亲', '兄弟', '姐妹', '儿子', '女儿'];
?>
<div class="calc-relation">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="calc-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'query_str')->textInput(['id' => 'query-str', 'readonly' => 'true', 'value' => '我']) ?>

        <?= $form->field($model, 'query')->textInput(['id' => 'query', 'type' => 'hidden'])->label(false) ?>

        <div class="form-group">
            <?php foreach ($relations as $k => $v): ?>
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
            let relations = <?= json_encode($relations) ?>;

            window.onload = () => {
                refreshQueryStr();
            };

            function appendRelation(relation) {
                let query = $('#query');
                query.val(query.val() + relation);
                refreshQueryStr();
            }

            function refreshQueryStr() {
                let query_str = '我';
                let query = $('#query').val().split('');
                for (let relation of query) {
                    query_str += '的' + relations[parseInt(relation)];
                }
                $('#query-str').val(query_str);
            }
            
            function deleteRelation() {
                let query = $('#query');
                if (query.val()) {
                    query.val(query.val().substring(0, query.val().length - 1));
                }
                refreshQueryStr();
            }

            function clearRelation() {
                $('#query').val('');
                refreshQueryStr();
            }
        </script>

    </div>

    <div class="calc-result">

        <div class="alert alert-info">
            <?= nl2br(Html::encode($result)) ?>
        </div>

    </div>
</div>