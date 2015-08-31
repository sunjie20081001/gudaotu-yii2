<?php
/**
 * Created by PhpStorm.
 * User: sun
 * Date: 8/21/15
 * Time: 1:46 PM
 */
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model app\models\Comment */
?>

<div class="comment-item">
    <h3><?=Html::a($model->post->title,['site/view','slug'=>$model->post->slug]);?></h3>
    <div class="comment-date">
        <?=\yii::$app->formatter->asDate($model->created_at,'Y-M-d')?>
    </div>
    <div class="comment-content">
        <?=Html::encode($model->content);?>
    </div>
</div>
