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

<?php $form = ActiveForm::begin();?>

<?= $form->field($model, 'display_name');?>
<?= $form->field($model, 'email');?>
<?= $form->field($model, 'avatar');?>
<?= $form->field($model, 'description');?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end();?>