<?php

/* @var $this yii\web\View */
/* @var $people_count integer */
/* @var $relations_count integer */

$this->title = '我的家 ' . date('Y');
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>我的家 <?= date('Y') ?></h1>

        <p class="lead">家庭成员信息检索库</p>

        <p><a class="btn btn-lg btn-success" href="/person/index">看看我有哪些家庭成员</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>家庭成员</h2>

                <p>管理所有家庭成员的详细信息。</p>
                <p>共有 <strong><?= $people_count ?></strong> 个家庭成员</p>

                <p><a class="btn btn-default" href="/person/index">家庭成员 &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>家庭关系</h2>

                <p>通过管理基本的父母子女关系构建起家庭关系网。</p>
                <p>共有 <strong><?= $relations_count ?></strong> 条关系</p>

                <p><a class="btn btn-default" href="/relation/index">家庭关系 &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>关系计算器</h2>

                <p>计算两个家庭成员之间有何联系。</p>
                <p>联系将用亲子、夫妻、兄弟姐妹关系来呈现。</p>

                <p><a class="btn btn-default" href="/calc/relation">关系计算器 &raquo;</a>
                </p>
            </div>
        </div>
        <div class="row">
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
