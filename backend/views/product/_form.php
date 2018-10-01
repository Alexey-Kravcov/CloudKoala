<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\product\ProductSection */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form-section">

    <? //dump($images);?>
    <div id="tabs">
        <ul>
            <li><a href="#product-tab1">Основное</a></li>
            <li><a href="#product-tab2">Описание</a></li>
            <li><a href="#product-tab3">Дополнительно</a></li>
            <li><a href="#product-tab4">SEO</a></li>
        </ul>
        <?php $form = ActiveForm::begin(); ?>
        <div id="product-tab1">
            <?= $form->field($model, 'name')->textInput(['class' => 'text-input source-translit']); ?>
            <?= $form->field($model, 'code')->textInput(['class' => 'text-input target-translit']); ?>
            <?= $form->field($model, 'active')->checkbox(['uncheck'=> 0], false); ?>
            <?= $form->field($model, 'sort')->textInput(['class' => 'number-input']); ?>
        </div>
        <div id="product-tab2">
            <?= $form->field($model, 'preview_image')->hiddenInput(); ?>
            <?= $form->field($images, 'preview_image')->widget(FileInput::classname(), [
                'options' => [
                    'accept' => 'image/*',
                ],
                'pluginOptions' => [
                    'uploadUrl' => \yii\helpers\Url::to('preview-image-upload'),
                    'uploadExtraData' => [
                        'type' => 'section',
                    ],
                    'allowedFileExtensions' => ['jpg', 'png', 'gif'],
                    'initialPreview' => $preview,
                    'showUpload' => true,
                    'showRemove' => false,
                    'dropZoneEnabled' => false,

                ],
                'pluginEvents' => [
                    'fileuploaded' => 'function(event, data, previewId, index) {
                jQuery("#productsection-preview_image").val(data.response);            
            }',
                ],
            ])->label(false);?>
            <?= $form->field($model, 'preview_text')->textArea(['class'=>'html-text']); ?>
        </div>
        <div id="product-tab3">
            <?=Html::a( "Новое свойство", Url::to(['product/create-property', 'type'=>'section']), ['class'=>'btn btn-sm btn-info']); ?>
            <? include('property_block.php'); ?>

        </div>
        <div id="product-tab4">
            <?= $form->field($seo, 'meta_title')->textInput(['class' => 'text-input']); ?>
            <?= $form->field($seo, 'meta_keywords')->textarea(['class' => 'admin-textarea']); ?>
            <?= $form->field($seo, 'meta_description')->textarea(['class' => 'admin-textarea']); ?>
            <?= $form->field($seo, 'section_id')->hiddenInput()->label(''); ?>
        </div>

        <?= $form->field($model, 'depth')->hiddenInput()->label('') ?>
        <?= $form->field($model, 'parent')->hiddenInput()->label('') ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?= Html::input('hidden', 'apply', 0 ); ?>
            <?= Html::button('Применить', ['class' => 'btn btn-info apply-button']) ?>
            <?= Html::a('Отмена', \yii\helpers\Url::previous(), ['class' => 'btn btn-default']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>
