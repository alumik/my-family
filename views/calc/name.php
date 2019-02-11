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

        <?= $form->field($model, 'query_str')->textInput(['id' => 'query-str', 'readonly' => 'true', 'value' => '我的']) ?>

        <?= $form->field($model, 'query')->textInput(['id' => 'query', 'type' => 'hidden'])->label(false) ?>

        <div class="form-group">
            <?php foreach ($relations as $k => $v): ?>
                <?= Html::button($v, ['class' => 'btn btn-default', 'onclick' => 'setRelation(' . $k . ')']); ?>
            <?php endforeach; ?>
            <?= Html::button('的', ['class' => 'btn btn-primary', 'onclick' => 'appendRelation()']) ?>
            <?= Html::button('删除', ['class' => 'btn btn-danger', 'onclick' => 'deleteRelation()']) ?>
            <?= Html::button('清空', ['class' => 'btn btn-danger', 'onclick' => 'clearRelation()']) ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton('计算', ['class' => 'btn btn-success', 'onclick' => 'appendLastRelation()']) ?>
        </div>

        <?php ActiveForm::end(); ?>

        <script type="application/javascript">
            let current_relation = -1;
            let relations = <?= json_encode($relations) ?>;

            window.onload = () => {
                let query = $('#query');
                if (query.val()) {
                    current_relation = parseInt(query.val()[query.val().length - 1]);
                    query.val(query.val().substring(0, query.val().length - 1));

                }
                refreshQueryStr();
            };

            function setRelation(relation) {
                current_relation = relation;
                refreshQueryStr();
            }

            function appendRelation() {
                let query = $('#query');
                if (current_relation !== -1) {
                    query.val(query.val() + current_relation);
                }
                current_relation = -1;
                refreshQueryStr();
            }

            function refreshQueryStr() {
                let query_str = '我的';
                let query = $('#query').val().split('');
                for (let relation of query) {
                    query_str += relations[parseInt(relation)] + '的';
                }
                if (current_relation !== -1) {
                    query_str += relations[parseInt(current_relation)];
                }
                $('#query-str').val(query_str);
            }
            
            function deleteRelation() {
                if (current_relation === -1) {
                    let query = $('#query');
                    if (query.val()) {
                        query.val(query.val().substring(0, query.val().length - 1));
                    }
                } else {
                    current_relation = -1;
                }
                refreshQueryStr();
            }

            function clearRelation() {
                current_relation = -1;
                $('#query').val('');
                refreshQueryStr();
            }

            function appendLastRelation() {
                if (current_relation !== -1) {
                    let query = $('#query');
                    query.val(query.val() + current_relation);
                }
            }
        </script>

    </div>

    <div class="calc-result">

        <div class="alert alert-info">
            <?= nl2br(Html::encode($result)) ?>
        </div>

    </div>
</div>
