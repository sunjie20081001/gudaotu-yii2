<?php
/**
 * Created by PhpStorm.
 * User: sun
 * Date: 8/21/15
 * Time: 1:46 PM
 */
use yii\helpers\Html;
/* @var $this yii\web\View */

print_r($model);
?>

<?= Html::a(Html::encode($model->title),['site/view','slug' => $model->slug])?>

