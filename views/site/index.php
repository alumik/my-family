<?php

/* @var $this yii\web\View */

$this->title = '我的家';
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

                <p><a class="btn btn-default" href="/person/index">家庭成员 &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>家庭关系</h2>

                <p>通过管理基本的父母子女关系构建起家庭关系网。</p>

                <p><a class="btn btn-default" href="/relationship/index">家庭关系 &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>更多信息</h2>

                <p>查看有关于本网站的更多信息。</p>

                <p><a class="btn btn-default" href="/site/about">更多信息 &raquo;</a>
                </p>
            </div>
        </div>

    </div>
</div>
