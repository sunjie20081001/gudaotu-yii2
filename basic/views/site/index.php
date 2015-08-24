<?php

/* @var $this yii\web\View */

use yii\widgets\ListView;

$this->title = '网站名';


?>
<div class="site-index">
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => [],
        'summary' => false,
        'itemView' => '_item',
        'layout' => '{items}{pager}',
    ]);?>

</div>
