<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\menu\MenuItem */
/* @var $form yii\widgets\ActiveForm */
?>
<?
    $parentAr = [ '' => '...' ];
    foreach($items as $itemModel) {
        $item = $itemModel->getAttributes();
        $parentAr[$item['id']] = $item['name'];
    }
?>
<div class="menu-item-form edit-form">
    <div id="tabs">
        <ul>
            <li><a href="#menu-tab1">Основное</a></li>
        </ul>
        <div  id="menu-tab1">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'name')->textInput(['class'=>'text-input source-translit']) ?>

            <?= $form->field($model, 'code')->textInput(['class'=>'text-input target-translit']) ?>

            <?= $form->field($model, 'link')->textInput(['class'=>'text-input']) ?>

            <?= $form->field($model, 'parent')->dropDownList($parentAr, ['class'=>'select-input']) ?>

            <?= $form->field($model, 'sort')->textInput(['class'=>'number-input']) ?>

            <?= $form->field($model, 'css_class')->textInput(['class'=>'number-input']) ?>

            <?= $form->field($model, 'attributes')->textInput(['class'=>'text-input']) ?>

            <div class="form-group">
                <?= Html::submitButton((Yii::$app->request->get('id') > 0)? 'Обновить' : 'Добавить', ['class' => 'btn btn-primary']) ?>
                <?= Html::input('hidden', 'apply', 0 ); ?>
                <?= Html::button('Применить', ['class' => 'btn btn-info apply-button']) ?>
                <?= Html::a('Отмена', \yii\helpers\Url::previous(), ['class' => 'btn btn-default']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>
