<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\users\User */
/* @var $form ActiveForm */
?>
<div class="users-_form_login">

    <?php $form = ActiveForm::begin(); ?>

        <?//= $form->field($model, 'username') ?>
        <?= $form->field($model, 'email') ?>

        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- users-_form_login -->
