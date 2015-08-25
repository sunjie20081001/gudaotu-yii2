<?php

/* @var $this yii\web\View */

use yii\widgets\ListView;

$this->title = '首页';


?>
<div class="site-index row">
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'col'],
        'summary' => false,
        'itemView' => '_item',
        'layout' => '{items}{pager}',
    ]);?>

</div>
