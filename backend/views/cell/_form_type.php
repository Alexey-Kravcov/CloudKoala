<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\cell\CellType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cell-type-form edit-form">
    <div id="tabs">
        <ul>
            <li><a href="#type-tabs-1">Основное</a></li>
        </ul>
        <div id="type-tabs-1">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'class'=>'text-input source-translit']) ?>

            <?= $form->field($model, 'code')->textInput(['maxlength' => true, 'class'=>'text-input target-translit']) ?>

            <?= $form->field($model, 'sections')->checkbox(['uncheck'=> 0], false) ?>

            <?= $form->field($model, 'sort')->textInput(['class'=>'number-input']) ?>

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
