<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\cell\CellProperty;
use common\models\cell\CellPropertyEnum;


/* @var $this yii\web\View */
/* @var $model common\models\cell\CellProperty */
/* @var $form yii\widgets\ActiveForm */

$propertyTypes = CellProperty::getTypeArray();
?>

<div class="cell-property-form edit-form">
    <div id="tabs">
        <ul>
            <li><a href="#cell-property-tab1">Основное</a></li>
            <li><a href="#cell-property-tab2">Анонс</a></li>
            <li><a href="#cell-property-tab3">Подробно</a></li>
        </ul>
        <?php $form = ActiveForm::begin(); ?>
        <div id="cell-property-tab1">

            <?= $form->field($model, 'name')->textInput(['class' => 'text-input source-translit']) ?>
            <?= $form->field($model, 'code')->textInput(['class' => 'text-input target-translit']) ?>
            <?= $form->field($model, 'active')->checkbox(['unless'=>0], false); ?>
            <?= $form->field($model, 'sort')->textInput(['class' => 'number-input']) ?>
            <?= $form->field($model, 'default_value')->textInput(['class' => 'text-input default-value-field']) ?>
            <?= $form->field($model, 'property_type')->dropDownList($propertyTypes, ['class' => 'select-input property-type-select']); ?>
            <?= $form->field($model, 'cell_id')->hiddenInput()->label(false); ?>
            <?= $form->field($model, 'own')->hiddenInput()->label(false); ?>
            <?= $form->field($model, 'multiple')->checkbox(); ?>
            <?= $form->field($model, 'filtrable')->checkbox(); ?>
            <?= $form->field($model, 'required')->checkbox(); ?>
            <?= $form->field($model, 'description')->checkbox(); ?>
            
            
            <div id="list-fields" class="property-advance <?=($model->property_type == 'L') ? 'show' : ''; ?>">
                <?= CellProperty::getListEnumArea($propEnum); ?>
            </div>

            <div id="link-setting" class="property-advance <?=($model->property_type == 'LS' || $model->property_type == 'LE') ? 'show' : ''; ?>">
                <?= CellProperty::getLinkSetting($model, $propEnum); ?>
            </div>


        </div>

        <div id="cell-property-tab1">

        </div>

        <div id="cell-property-tab1">

        </div>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                <?= Html::input('hidden', 'apply', 0 ); ?>
                <?= Html::button('Применить', ['class' => 'btn btn-info apply-button']) ?>
                <?= Html::a('Отмена', \yii\helpers\Url::previous('edit-cell'), ['class' => 'btn btn-default']) ?>
            </div>
            <? ActiveForm::end(); ?>
    </div>
</div>
