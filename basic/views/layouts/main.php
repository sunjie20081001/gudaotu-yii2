<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
    <?= \app\widgets\Menu::widget()?>
<div class="wrap clearfix">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            'itemTemplate' => '<li>{link}<span>>></span></li>',
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer clearfix">
    <div class="container">
        <div class="footer-us">
            <ul>
                <li><a href="">关于我们</a></li>
                <li><a href="">加入我们</a></li>
                <li><a href="">投稿我们</a></li>
            </ul>
        </div>
        <p class="footer-copyright">&copy; <a href="">鼓捣兔</a><?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
