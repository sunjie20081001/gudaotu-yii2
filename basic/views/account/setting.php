<?php
/**
 * Created by PhpStorm.
 * User: sun
 * Date: 8/21/15
 * Time: 3:56 PM
 */

use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
$this->title = '个人设置';

?>
<h2>个人设置</h2>
<div class="post-form account clearfix">
    <!--头像!-->
    <div class="account-avatar">
        <div class="account-avatar-img">
            <?=Html::a( Html::img($model->avatar,['class' => 'account-a-img']))?>
        </div>
    </div>
    <div class="form-container">
<?php $form = ActiveForm::begin();?>
        <?= $form->field($model, 'display_name');?>
        <?= $form->field($model, 'email');?>
        <?= $form->field($model, 'description');?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end();?>
    </div>
</div>
