<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\cell\CellItem */
/* @var $form yii\widgets\ActiveForm */

$hasSections = ($model->getCellType()->one()->sections > 0) ? true : false;
?>

<div class="cell-item-form edit-form">
    <div id="tabs">
        <ul>
            <li><a href="#item-tabs-1">Основное</a></li>
            <? if($hasSections) { ?>
                <li><a href="#item-tabs-2">Свойства разделов</a></li>
            <? } ?>
            <li><a href="#item-tabs-3">Свойства элементов</a></li>
        </ul>
        <div id="item-tabs-1">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'name')->textInput(['class'=>'text-input source-translit']) ?>

            <?= $form->field($model, 'code')->textInput(['class'=>'text-input target-translit']) ?>

            <?= $form->field($model, 'active')->checkbox(['uncheck'=> 0], false) ?>

            <?= $form->field($model, 'sort')->textInput(['class'=>'number-input']) ?>

            <?= $form->field($model, 'searchable')->checkbox(['uncheck'=> 0], false) ?>
<? //dump($typeModel); ?>
            <?if($hasSections) { ?>
                <?= $form->field($model, 'section_name')->textInput(['class'=>'text-input']) ?>
                <?= $form->field($model, 'sections_name')->textInput(['class'=>'text-input']) ?>
            <?}?>

            <?= $form->field($model, 'element_name')->textInput(['class'=>'text-input']) ?>
            <?= $form->field($model, 'elements_name')->textInput(['class'=>'text-input']) ?>
            <?= $form->field($model, 'cell_type_id')->hiddenInput(['value'=>$typeModel->id])->label(''); ?>


            <div class="form-group">
                <?= Html::submitButton((Yii::$app->request->get('id') > 0)? 'Обновить' : 'Добавить', ['class' => 'btn btn-primary']) ?>
                <?= Html::input('hidden', 'apply', 0 ); ?>
                <?= Html::button('Применить', ['class' => 'btn btn-info apply-button']) ?>
                <?= Html::a('Отмена', \yii\helpers\Url::previous(), ['class' => 'btn btn-default']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
        <? if($hasSections) { ?>
            <div id="item-tabs-2">
                <?= \common\models\cell\CellProperty::getPropertyTab('section', $model->id); ?>
            </div>
        <? } ?>
        <div id="item-tabs-3">
            <?= \common\models\cell\CellProperty::getPropertyTab('element', $model->id); ?>
        </div>
    </div>
</div>
