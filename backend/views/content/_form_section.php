<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use common\models\cell\CellPropertyRender;

/* @var $this yii\web\View */
/* @var $model common\models\cell\CellSection */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cell-section-form edit-form">
    <div id="tabs">
        <ul>
            <li><a href="#section-tab1">Основное</a></li>
            <li><a href="#section-tab2">Описание</a></li>
            <li><a href="#section-tab3">Дополнительно</a></li>
            <li><a href="#section-tab4">SEO</a></li>
        </ul>
        
        <?php $form = ActiveForm::begin(); ?>
        
        <div id="section-tab1">
            <?= $form->field($model, 'name')->textInput(['class'=>'text-input source-translit']) ?>
            <?= $form->field($model, 'code')->textInput(['class'=>'text-input target-translit']) ?>

            <?= $form->field($model, 'active')->checkbox(['uncheck'=> 0], false) ?>
            <?= $form->field($model, 'sort')->textInput(['class'=>'number-input']) ?>
        </div>
        <div id="section-tab2">
            <?= $form->field($model, 'preview_picture')->hiddenInput(); ?>
            <?= $form->field($imageModel, 'preview_image')->widget(FileInput::classname(), [
                'options' => [
                    'accept' => 'image/*',
                ],
                'pluginOptions' => [
                    'uploadUrl' => \yii\helpers\Url::to('image-upload'),
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
                        jQuery("#cellsection-preview_picture").val(data.response);            
                    }',
                ],
            ])->label(false);?>
            <?= $form->field($model, 'preview_text')->textarea(['class'=>'html-text']) ?>
        </div>
        <div id="section-tab3">
            <?=Html::a( "Новое свойство", Url::to(['cell/create-property', 'type'=>'section']), ['class'=>'btn btn-sm btn-info']); ?>
            <?= CellPropertyRender::renderBlock($arProperties, $form); ?>
        </div>
        <div id="section-tab4">
            <?= $form->field($seoModel, 'meta_title')->textInput(['class' => 'text-input']); ?>
            <?= $form->field($seoModel, 'meta_keywords')->textarea(['class' => 'admin-textarea']); ?>
            <?= $form->field($seoModel, 'meta_description')->textarea(['class' => 'admin-textarea']); ?>
        </div>

        <?= $form->field($model, 'depth')->hiddenInput()->label('') ?>
        <?= $form->field($model, 'parent')->hiddenInput()->label('') ?>
        <?= $form->field($model, 'cell_type_id')->hiddenInput()->label('') ?>
        <?= $form->field($model, 'cell_id')->hiddenInput()->label('') ?>
        <?= $form->field($model, 'user_id')->hiddenInput()->label(''); ?>

            <?//= $form->field($model, 'created_at')->textInput() ?>

            <?//= $form->field($model, 'updated_at')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton((Yii::$app->request->get('section_id') > 0)? 'Обновить' : 'Добавить', ['class' => 'btn btn-primary']) ?>
            <?= Html::input('hidden', 'apply', 0 ); ?>
            <?= Html::button('Применить', ['class' => 'btn btn-info apply-button']) ?>
            <?= Html::a('Отмена', Url::previous(), ['class' => 'btn btn-default']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
