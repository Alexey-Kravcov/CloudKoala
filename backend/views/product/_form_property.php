<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\product\ProductProperty */
/* @var $form ActiveForm */

$types = [
  'S' => 'Строка',
  'L' => 'Список',
  'B' => 'Да/Нет',
  'F' => 'Файл',
  'H' => 'HTML текст',  
  'LS' => 'Привязка к разделу',
  'LE' => 'Привязка к элементу',
];
?>
<div class="property-form">
    <div id="tabs">
        <ul>
            <li><a href="#product-tab1">Основное</a></li>
            <li><a href="#product-tab2">Описание</a></li>
            <li><a href="#product-tab3">Дополнительно</a></li>
        </ul>
        <?php $form = ActiveForm::begin(); ?>
        <div id="product-tab1">
            <?= $form->field($model, 'name')->textInput(['class' => 'text-input']); ?>
            <?= $form->field($model, 'code')->textInput(['class' => 'text-input']); ?>
            <?= $form->field($model, 'active')->checkbox(['unless'=>0], false); ?>
            <?= $form->field($model, 'sort')->textInput(['class' => 'number-input']); ?>
            <?= $form->field($model, 'default_value')->textInput(['class' => 'text-input']); ?>
            <?= $form->field($model, 'property_type')->dropDownList($types, ['class' => 'select-input']); ?>
            <?= $form->field($model, 'implement')->hiddenInput()->label(''); ?>
            <?= $form->field($model, 'multiple')->checkbox(); ?>
            <?= $form->field($model, 'filtrable')->checkbox(); ?>
            <?= $form->field($model, 'required')->checkbox(); ?>
            <?= $form->field($model, 'description')->checkbox(); ?>
        </div>
        <div id="product-tab2">

        </div>
        <div id="product-tab3">

        </div>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?= Html::input('hidden', 'apply', 0 ); ?>
            <?= Html::button('Применить', ['class' => 'btn btn-info apply-button']) ?>
            <?= Html::a('Отмена', \yii\helpers\Url::previous(), ['class' => 'btn btn-default']) ?>
        </div>
        <? ActiveForm::end(); ?>

</div><!-- product-_form_property -->
