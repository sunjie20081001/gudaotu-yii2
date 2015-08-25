<?php
/**
 * Created by PhpStorm.
 * User: sun
 * Date: 8/21/15
 * Time: 1:46 PM
 */
use yii\helpers\Html;
/* @var $this yii\web\View */

?>

<div class="item">
    <?= html::a( Html::img(Html::encode($model->img) ),['site/view', 'slug' => $model->slug], ['class' => 'item-img'] );?>
    <?= Html::a('<h3>'.Html::encode($model->title).'</h3>',['site/view','slug' => $model->slug])?>
</div>


