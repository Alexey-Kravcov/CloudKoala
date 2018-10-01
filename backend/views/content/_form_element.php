<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use common\models\cell\CellPropertyRender;

/* @var $this yii\web\View */
/* @var $model common\models\cell\CellElement */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cell-element-form edit-form">
    <div id="tabs">
        <ul>
            <li><a href="#cell-tab1">Основное</a></li>
            <li><a href="#cell-tab2">Анонс</a></li>
            <li><a href="#cell-tab3">Подробно</a></li>
            <li><a href="#cell-tab4">Дополнительно</a></li>
            <li><a href="#cell-tab5">SEO</a></li>
            <li><a href="#cell-tab6">Разделы</a></li>
            <li><a href="#cell-tab7">Торговый каталог</a></li>
        </ul>
        <?php $form = ActiveForm::begin(); ?>
        <div id="cell-tab1">
            <?= $form->field($model, 'name')->textInput(['class'=>'text-input source-translit']) ?>
            <?= $form->field($model, 'code')->textInput(['class'=>'text-input target-translit']) ?>
            <?= $form->field($model, 'active')->checkbox(['uncheck'=> 0], false) ?>
            <?= $form->field($model, 'sort')->textInput(['class'=>'number-input']) ?>
        </div>
        <div id="cell-tab2">
            <?= $form->field($model, 'preview_picture')->hiddenInput() ?>
            <?= $form->field($imageModel, 'preview_image')->widget(FileInput::classname(), [
                'options' => [
                    'accept' => 'image/*',
                ],
                'pluginOptions' => [
                    'uploadUrl' => \yii\helpers\Url::to('image-upload'),
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
                        jQuery("#cellelement-preview_picture").val(data.response);            
                    }',
                ],
            ])->label(false);?>
            <?= $form->field($model, 'preview_text')->textArea(['class'=>'admin-textarea html-text',]) ?>
        </div>
        <div id="cell-tab3">

            <? //dump($imageModel); ?>
            <?= $form->field($model, 'detail_picture')->hiddenInput() ?>
            <?= $form->field($imageModel, 'detail_image')->widget(FileInput::classname(), [
                'options' => [
                    'accept' => 'image/*',
                ],
                'pluginOptions' => [
                    'uploadUrl' => \yii\helpers\Url::to('image-upload'),
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
            ])->label(false);?>
            <?= $form->field($model, 'detail_text')->textArea(['class'=>'admin-textarea html-text',]) ?>
        </div>
        <div id="cell-tab4">
            <?=Html::a( "Новое свойство", Url::to(['content-property/create', 'type'=>'element']), ['class'=>'btn btn-sm btn-info']); ?>
            <?= CellPropertyRender::renderBlock($arProperties, $form); ?>
        </div>
        <div id="cell-tab5">
            <?= $form->field($seoModel, 'meta_title')->textInput(['class' => 'text-input']); ?>
            <?= $form->field($seoModel, 'meta_keywords')->textarea(['class' => 'admin-textarea']); ?>
            <?= $form->field($seoModel, 'meta_description')->textarea(['class' => 'admin-textarea']); ?>
        </div>
        <div id="cell-tab6">

        </div>
        <div id="cell-tab7">
        </div>

        <?= $form->field($model, 'cell_type_id')->hiddenInput()->label(false); ?>
        <?= $form->field($model, 'cell_id')->hiddenInput()->label(false); ?>
        <?
        //dump($model->getSection()->One());
        if( $model->getCellType()->One()->sections > 0) {
            echo $form->field($model, 'section_id')->hiddenInput()->label(false);
        } ?>
        <?= $form->field($model, 'user_id')->hiddenInput()->label(false); ?>

        <div class="form-group">
            <?= Html::submitButton((Yii::$app->request->get('element_id') > 0)? 'Обновить' : 'Добавить', ['class' => 'btn btn-primary']) ?>
            <?= Html::input('hidden', 'apply', 0 ); ?>
            <?= Html::button('Применить', ['class' => 'btn btn-info apply-button']) ?>
            <?= Html::a('Отмена', \yii\helpers\Url::previous(), ['class' => 'btn btn-default']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php
    Url::remember('', 'edit-cell');
?>
