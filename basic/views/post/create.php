<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Post */

$this->title = '发布文章';

?>
<div class="post-create post">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
        'isAdmin' =>$isAdmin,
    ]) ?>
</div>
