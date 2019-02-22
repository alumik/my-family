<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = '计算工具';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calc-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="calc-index-content">
        <div class="row">
            <div class="col-lg-4">
                <h2>关系计算器</h2>
                <p>计算两个家庭成员之间有何联系。</p>
                <p>联系将用亲子、夫妻、兄弟姐妹关系来呈现。</p>
                <p><a class="btn btn-default" href="/calc/relation">关系计算器 &raquo;</a>
                </p>
            </div>
            <div class="col-lg-4">
                <h2>称呼计算器</h2>
                <p>通过输入简单关系信息计算亲戚该如何称呼。</p>
                <p>太远的关系可能无法计算。</p>
                <p><a class="btn btn-default" href="/calc/name">称呼计算器 &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>农历阳历互转</h2>
                <p>输入阳历或农历日期读取当天信息。</p>
                <p><a class="btn btn-default" href="/calc/calendar">农历阳历互转 &raquo;</a></p>
            </div>
        </div>
    </div>

</div>
