<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\prices\Price */
/* @var $form yii\widgets\ActiveForm */
?>
<?
$groups = [''=>'Не показывать'];
foreach($buyers as $buyer){
    $data = $buyer->getAttributes();
    $groups[$data['id']] = $data['name'];
}
//dump($groups);
?>

<div class="price-form edit-form">
    <div id="tabs">
        <ul>
            <li><a href="#price-tab1">Основное</a></li>
        </ul>
        <div id="price-tab1">
            <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'class'=>'text-input source-translit']) ?>

                <?= $form->field($model, 'code')->textInput(['maxlength' => true, 'class'=>'text-input target-translit']) ?>

                <?= $form->field($model, 'description')->textInput(['maxlength' => true, 'class'=>'text-input']) ?>

                <?= $form->field($model, 'sort')->textInput(['class'=>'number-input']) ?>

                <?= $form->field($model, 'base')->checkbox(['uncheck'=>false], false) ?>

                <?= $form->field($model, 'ratio')->textInput(['class'=>'number-input']) ?>

                <?= $form->field($model, 'show_group_id')->dropDownList($groups); ?>

                <?= $form->field($model, 'buy_group_id')->dropDownList($groups); ?>

                <div class="form-group">
                    <?= Html::submitButton((Yii::$app->request->get('element_id') > 0)? 'Обновить' : 'Добавить', ['class' => 'btn btn-primary']) ?>
                    <?= Html::input('hidden', 'apply', 0 ); ?>
                    <?= Html::button('Применить', ['class' => 'btn btn-info apply-button']) ?>
                    <?= Html::a('Отмена', \yii\helpers\Url::previous(), ['class' => 'btn btn-default']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>

</div>
