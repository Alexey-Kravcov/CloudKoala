<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\menu\MenuGroup */
/* @var $form ActiveForm */
?>
<div class="menus-form-group edit-form">
    <div id="tabs">
        <ul>
            <li><a href="#menu-tab1">Основное</a></li>
        </ul>
        <div  id="menu-tab1">
            <?php $form = ActiveForm::begin(); ?>


                <?= $form->field($model, 'name')->textInput(['class'=>'text-input source-translit']) ?>

                <?= $form->field($model, 'code')->textInput(['class'=>'text-input target-translit']) ?>
                <?= $form->field($model, 'description')->textarea();?>
                <?= $form->field($model, 'sort')->textInput(['class'=>'number-input']) ?>
                <?= $form->field($model, 'css_class')->textInput(['class'=>'number-input']) ?>

                <div class="form-group">
                    <?= Html::submitButton((Yii::$app->request->get('element_id') > 0)? 'Обновить' : 'Добавить', ['class' => 'btn btn-primary']) ?>
                    <?= Html::input('hidden', 'apply', 0 ); ?>
                    <?= Html::button('Применить', ['class' => 'btn btn-info apply-button']) ?>
                    <?= Html::a('Отмена', \yii\helpers\Url::previous(), ['class' => 'btn btn-default']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>

</div><!-- menus-_form_group -->
