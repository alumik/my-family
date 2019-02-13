<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>上述错误信息表明该请求不能得到正确执行。</p>

    <p>如果你觉得这是服务器错误，请联系我们，谢谢。</p>

</div>
