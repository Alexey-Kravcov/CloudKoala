<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\components\ComponentList */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="component-list-form edit-form">
    <div id="tabs">
        <ul>
            <li><a href="#type-tabs-1">Основное</a></li>
        </ul>
        <div id="type-tabs-1">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'sort')->textInput() ?>

            <?= $form->field($model, 'group_id')->textInput() ?>

            <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

            <div class="params-block">
                <div class="params-list">
                    <?= $form->field($model, 'params')->hiddenInput() ?>
                    <?if(is_array($model->params)) {
                        foreach ($model->params as $k => $v) { ?>
                            <div class="param-item">
                                <?= Html::input('text', 'params[code][]', $k); ?> -
                                <?= Html::input('text', 'params[name][]', $v); ?>
                            </div>
                        <?
                        }
                    }?>
                    <div class="param-item">
                        <?= Html::input('text', 'params[code][]', '', ['placeholder'=>'Код']); ?> -
                        <?= Html::input('text', 'params[name][]', '', ['placeholder'=>'Название']); ?>
                    </div>
                </div>
                <div class="button">
                    <?=Html::a('Добавить параметр', ['#'], ['class'=>'btn btn-default add-params']);?>
                </div>
            </div>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
