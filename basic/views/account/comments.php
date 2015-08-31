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
<div class="post-form account clearfix">
    <div class="account-tabs">
        <ul>
            <li class="active"><a href="">评论</a></li>
            <li ><a href="">赞文</a></li>
        </ul>
    </div>
    <div class="account-content">
        <div class="account-comments">
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions'  => ['class' => 'col'],
                'summary' => false,
                'itemView' => '_item',
                'layout' => '{items}{pager}'
            ]);?>
        </div>
    </div>
</div>