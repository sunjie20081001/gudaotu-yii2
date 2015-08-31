<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Post */

$this->title = '编辑文章: ' . ' ' . $model->title;
?>
<div class="post-update">
    <h1>编辑</h1>
    <!--信息提示框-->
    <div class="alert-message">
        <?=\app\widgets\Alert::widget()?>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
        'isAdmin' => $isAdmin,
    ]) ?>

</div>
