<?php

use \common\models\product\ProductSection;
use kartik\file\FileInput;
use \backend\components\ProductHelper;
use \common\models\product\ProductElement;
use \common\models\product\ProductProperty;

/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 25.03.2017
 * Time: 20:51
 */

 foreach($properties as $property) {
    $arProp = $property->getAttributes();
    $type = $property['property_type'];
    $valModel = $propValue[$arProp['id']];
    // dump($propValue);
    ?>
    <div class="property_item">

        <? // тип - строка
        if($type == "S") { ?>
            <div class="property_title">
                <?=$arProp['name'];?>
            </div>
            <? ProductProperty::getEditRowTextProperty($arProp, $valModel);
        } ?>

        <? // тип - список
        if($type == "L") {
            $enums = $listEnums[$arProp['id']]; ?>
            <div class="property_title inline">
                <?=$arProp['name'];?>
            </div>
            <?
                ProductProperty::getEditRowListProperty($arProp, $valModel, $enums);
        } ?>

        <? // тип - да/нет
        if($type == "B") {
            $value = $valModel[0]->value;
            $checked = ($value > 0) ? 'checked' : '';
            ?>
            <div class="property_title inline">
                <?=$arProp['name'];?>
            </div>
            <div class="property-input inline">
                <input type="checkbox" name="properties[<?=$arProp['id'];?>]" value="1" <?=$checked;?> />
                <input type="hidden" name="properties['false_<?=$arProp['id'];?>']" value="0"  />
            </div>
        <?} ?>

        <? // тип - файл
        if($type == "F") {
            $propertyImageModel = new \common\models\product\ImagesForm();
            $propertyImageModel->$arProp['code'] = 0;
            // dump($propertyImageModel);
            ?>
            <div class="property_title">
                <?=$arProp['name'];?>
            </div>
            <?
            ProductProperty::getEditRowFileProperty($arProp, $valModel, $form); ?>
        <?} ?>

        <? // тип - HTML текст
        if($type == "H") { ?>
            <div class="property_title">
                <?=$arProp['name'];?>
            </div>
            <?
            ProductProperty::getEditRowTextProperty($arProp, $valModel);
        } ?>

        <? // тип - привязка к разделу
        if($type == "LS") { ?>
            <div class="property_title inline">
                <?=$arProp['name'];?>
            </div>
            <?
            ProductProperty::getEditRowLinkProperty($arProp, $valModel);
        } ?>

        <? // тип - привязка к элементу
        if($type == "LE") { ?>
            <div class="property_title inline">
                <?=$arProp['name'];?>
            </div>
            <?
            ProductProperty::getEditRowLinkProperty($arProp, $valModel);
        } ?>
    </div>
<? }?>