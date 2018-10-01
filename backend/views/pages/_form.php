<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\pages\PageList */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-form edit-form">
    <div id="tabs">
        <ul>
            <li><a href="#price-tab1">Основное</a></li>
        </ul>
        <div id="price-tab1">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'class'=>'text-input source-translit']) ?>

            <?= $form->field($model, 'code')->textInput(['maxlength' => true, 'class'=>'text-input target-translit']) ?>

            <?= $form->field($model, 'alias')->textInput(['maxlength' => true, 'class'=>'text-input']) ?>

            <?= $form->field($model, 'css_class')->textInput(['maxlength' => true, 'class'=>'text-input']) ?>

            <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true, 'class'=>'text-input']) ?>

            <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true, 'class'=>'text-input']) ?>

            <?= $form->field($model, 'meta_description')->textarea(['maxlength' => true,'class'=>'admin-textarea']) ?>

            <div class="form-group">
                <?= Html::submitButton((Yii::$app->request->get('id') > 0)? 'Обновить' : 'Добавить', ['class' => 'btn btn-primary']) ?>
                <?= Html::input('hidden', 'apply', 0 ); ?>
                <?= Html::button('Применить', ['class' => 'btn btn-info apply-button']) ?>
                <?= Html::a('Отмена', \yii\helpers\Url::previous(), ['class' => 'btn btn-default']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
