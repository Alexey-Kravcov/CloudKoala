<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\product\ProductPropertyEnum;

/* @var $this yii\web\View */
/* @var $model common\models\product\ProductProperty */
/* @var $form ActiveForm */

$types = [
  'S' => 'Строка',
  'L' => 'Список',
  'B' => 'Да/Нет',
  'F' => 'Файл',
  'H' => 'HTML текст',  
  'LS' => 'Привязка к разделу',
  'LE' => 'Привязка к элементу',
];

$own = [
    '' => '...',
    'element' => 'Товару',
    'section' => 'Разделу',
];
?>
<div class="property-form">
    <div id="tabs">
        <ul>
            <li><a href="#product-tab1">Основное</a></li>
            <li><a href="#product-tab2">Описание</a></li>
            <li><a href="#product-tab3">Дополнительно</a></li>
        </ul>
        <?php $form = ActiveForm::begin(); ?>
        <div id="product-tab1">
            <?= $form->field($model, 'name')->textInput(['class' => 'text-input source-translit']); ?>
            <?= $form->field($model, 'code')->textInput(['class' => 'text-input target-translit']); ?>
            <?= $form->field($model, 'active')->checkbox(['unless'=>0], false); ?>
            <?= $form->field($model, 'sort')->textInput(['class' => 'number-input']); ?>
            <?= $form->field($model, 'default_value')->textInput(['class' => 'text-input']); ?>
            <?= $form->field($model, 'property_type')->dropDownList($types, ['class' => 'select-input property-type-select']); ?>
            <?//= $form->field($model, 'implement')->hiddenInput()->label(''); ?>
            <?= $form->field($model, 'implement')->dropDownList($own, ['class'=>'select-input']); ?>
            <?= $form->field($model, 'multiple')->checkbox(); ?>
            <?= $form->field($model, 'filtrable')->checkbox(); ?>
            <?= $form->field($model, 'required')->checkbox(); ?>
            <?= $form->field($model, 'description')->checkbox(); ?>

            <div id="list-fields" class="property-advance <?=($model->property_type == 'L') ? 'show' : ''; ?>">
                <h3>Варианты значений списка</h3>
                <div class="row center">
                    <div class="col-md-3">
                       Символьный код
                    </div>
                    <div class="col-md-6">
                        Название
                    </div>
                    <div class="col-md-3">
                        По умолчанию
                    </div>
                </div>
                <div id="list-row-data">
                    <?
                    $i = 0;
                    //dump($propEnum, true);
                    if(is_array($propEnum)) {
                        foreach ($propEnum as $enumModel) {
                            $enumAttr = $enumModel->getAttributes();
                            $checked = ($enumAttr['by_default'] > 0) ? 'checked' : '';
                            ProductPropertyEnum::getEditRowEnum($i, $enumAttr, $checked);
                            $i++;
                        }
                    } elseif($propEnum->code != '') {
                        $enumAttr = $enumModel->getAttributes();
                        $checked = ($enumAttr['by_default'] > 0) ? 'checked' : '';
                        ProductPropertyEnum::getEditRowEnum($i, $enumAttr, $checked);
                        $i++;
                    }
                    $end = $i + 3;
                    for($i ; $i < $end; $i++) { ?>
                        <div class="row">
                            <input type="hidden" name="property-enum[<?=$i;?>][id]" value="0" />
                            <div class="col-md-3">
                                <input type="text" name="property-enum[<?=$i;?>][code]" class="number-input" />
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="property-enum[<?=$i;?>][name]" class="text-input" />
                            </div>
                            <div class="col-md-3 center">
                                <input type="checkbox" name="property-enum[<?=$i;?>][by_default]" value="1" class="by_default" />
                            </div>
                        </div>
                    <?} ?>
                </div>
                <div class="row center">
                    <input type="hidden" name="rows-count" value="<?=$i;?>" />
                    <a href="" id="more-enum-button" class="btn btn-default"> Ещё </a>
                </div>

            </div>
        </div>
        <div id="product-tab2">

        </div>
        <div id="product-tab3">

        </div>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?= Html::input('hidden', 'apply', 0 ); ?>
            <?= Html::button('Применить', ['class' => 'btn btn-info apply-button']) ?>
            <?= Html::a('Отмена', \yii\helpers\Url::previous(), ['class' => 'btn btn-default']) ?>
        </div>
        <? ActiveForm::end(); ?>

</div><!-- product-_form_property -->
