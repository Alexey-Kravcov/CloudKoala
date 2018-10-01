<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\main\MainSettings;

/* @var $this yii\web\View */
/* @var $model common\models\main\MainSettings */
/* @var $form yii\widgets\ActiveForm */

$systemSettings = MainSettings::getSystemCode();
?>

<div class="main-settings-form edit-form">
    <div id="tabs">
        <ul>
            <li><a href="#setting-tabs-1">Основное</a></li>
        </ul>
        <div id="setting-tabs-1">
            <?php $form = ActiveForm::begin(); ?>
            <? if(in_array($model->code, $systemSettings)) { ?>
                <h4>Параметр: <?= $model->name; ?></h4>
                <h4>Символьный код: <?= $model->code; ?></h4>
            <?} else {
                echo $form->field($model, 'name')->textInput(['class' => 'text-input source-translit']);
                echo $form->field($model, 'code')->textInput(['class' => 'text-input target-translit']);
            } ?>
            <?= $form->field($model, 'value')->textInput(['class'=>'text-input']) ?>

        </div>

        <div class="form-group">
            <?= Html::submitButton((Yii::$app->request->get('id') > 0)? 'Обновить' : 'Добавить', ['class' => 'btn btn-primary']) ?>
            <?= Html::input('hidden', 'apply', 0 ); ?>
            <?= Html::button('Применить', ['class' => 'btn btn-info apply-button']) ?>
            <?= Html::a('Отмена', \yii\helpers\Url::previous('main-settings'), ['class' => 'btn btn-default']) ?>
        </div>

            <?php ActiveForm::end(); ?>
    </div>
</div>
