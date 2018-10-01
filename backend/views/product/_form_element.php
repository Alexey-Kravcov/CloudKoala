<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\product\ProductElement */
/* @var $form ActiveForm */
?>
<div class="product-form-element  edit-form">
    <div id="tabs">
        <ul>
            <li><a href="#product-tab1">Основное</a></li>
            <li><a href="#product-tab2">Анонс</a></li>
            <li><a href="#product-tab3">Подробно</a></li>
            <li><a href="#product-tab4">Дополнительно</a></li>
            <li><a href="#product-tab5">SEO</a></li>
            <li><a href="#product-tab6">Разделы</a></li>
            <li><a href="#product-tab7">Торговый каталог</a></li>
        </ul>
        <?php $form = ActiveForm::begin(); ?>
        <div id="product-tab1">
            <?= $form->field($model, 'name')->textInput(['class'=>'text-input']) ?>
            <?= $form->field($model, 'code')->textInput(['class'=>'text-input']) ?>
            <?= $form->field($model, 'active')->checkbox(['uncheck'=> 0], false) ?>
            <?= $form->field($model, 'sort')->textInput(['class'=>'number-input']) ?>
        </div>
        <div id="product-tab2">
            <?= $form->field($model, 'preview_picture')->hiddenInput() ?>
            <?= $form->field($images, 'preview_image')->widget(FileInput::classname(), [
                'options' => [
                    'accept' => 'image/*',
                ],
                'pluginOptions' => [
                    'uploadUrl' => \yii\helpers\Url::to('preview-image-upload'),
                    'uploadExtraData' => [
                        'type' => 'element',
                    ],
                    'allowedFileExtensions' => ['jpg', 'png', 'gif'],
                    'initialPreview' => $preview,
                    'showUpload' => true,
                    'showRemove' => false,
                    'dropZoneEnabled' => false,

                ],
                'pluginEvents' => [
                    'fileuploaded' => 'function(event, data, previewId, index) {
                        jQuery("#productelement-preview_picture").val(data.response);            
                    }',
                ],
            ]);?>
            <?= $form->field($model, 'preview_text')->textArea(['class'=>'admin-textarea html-text',]) ?>
        </div>
        <div id="product-tab3">
            <?= $form->field($model, 'detail_picture')->hiddenInput() ?>
            <?= $form->field($images, 'detail_image')->widget(FileInput::classname(), [
                'options' => [
                    'accept' => 'image/*',
                ],
                'pluginOptions' => [
                    'uploadUrl' => \yii\helpers\Url::to('preview-image-upload'),
                    'uploadExtraData' => [
                        'type' => 'element',
                    ],
                    'allowedFileExtensions' => ['jpg', 'png', 'gif'],
                    'initialPreview' => $detail,
                    'showUpload' => true,
                    'showRemove' => false,
                    'dropZoneEnabled' => false,

                ],
                'pluginEvents' => [
                    'fileuploaded' => 'function(event, data, previewId, index) {
                            jQuery("#productelement-detail_picture").val(data.response);            
                        }',
                ],
            ]);?>
            <?= $form->field($model, 'detail_text')->textArea(['class'=>'admin-textarea', 'id'=>'v-editor']) ?>
        </div>
        <div id="product-tab4">
            <?=Html::a( "Новое свойство", Url::to(['product/create-property', 'type'=>'element']), ['class'=>'btn btn-sm btn-info']); ?>
            <? include('property_block.php'); ?>
        </div>
        <div id="product-tab5">
            <?= $form->field($seo, 'meta_title')->textInput(['class' => 'text-input']); ?>
            <?= $form->field($seo, 'meta_keywords')->textarea(['class' => 'admin-textarea']); ?>
            <?= $form->field($seo, 'meta_description')->textarea(['class' => 'admin-textarea']); ?>
            <?= $form->field($seo, 'element_id')->hiddenInput()->label(''); ?>
        </div>
        <div id="product-tab6">
            
        </div>
        <div id="product-tab7">
        </div>

            <?= $form->field($model, 'section_id')->hiddenInput()->label('') ?>


        <div class="form-group">
            <?= Html::submitButton((Yii::$app->request->get('element_id') > 0)? 'Обновить' : 'Добавить', ['class' => 'btn btn-primary']) ?>
            <?= Html::input('hidden', 'apply', 0 ); ?>
            <?= Html::button('Применить', ['class' => 'btn btn-info apply-button']) ?>
            <?= Html::a('Отмена', \yii\helpers\Url::previous(), ['class' => 'btn btn-default']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div><!-- product-_form_element -->
