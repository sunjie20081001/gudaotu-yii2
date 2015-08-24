<?php
/**
 * Created by PhpStorm.
 * User: sun
 * Date: 8/21/15
 * Time: 5:23 PM
 */

use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;
/* @var $this yii\web\View */

$this->title = '我的评论';

?>

<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemOptions' => [],
    'summary' => false,
    'itemView' => '_item',
    'layout' => '{items}{pager}',
]);?>
