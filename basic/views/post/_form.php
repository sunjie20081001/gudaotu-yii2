<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\models\Term;
use app\models\User;
use app\models\Post;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>



    <?= $form->field($model, 'title')->textInput() ?>

    <?= $form->field($model, 'user_id')->dropDownList(User::getAuthors()) ?>

    <?= $form->field($model, 'term_id')->dropDownList(Term::allTermsArray()); ?>

    <?= $form->field($model, 'excerpt')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'slug')->textInput();?>

    <?= $form->field($model, 'keyword')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>



    <?= $form->field($model, 'status')->dropDownList(Post::statusLabels()) ?>

    <?= $form->field($model, 'comment_status')->dropDownList(Post::commentStatusLabels()) ?>

    <?= $form->field($model, 'img')?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
