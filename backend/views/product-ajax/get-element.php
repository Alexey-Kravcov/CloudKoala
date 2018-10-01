<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\product\ProductElementSearchModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="product-element-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="filter-block">
        <input type="text" name="get-name" class="text-input" />
        <button>Найти</button>
    </div>
    <div class="elements-list">
        <?
        $models = $dataProvider->getModels();
        //dump($models);
        foreach($models as $model) {
            $element = $model->getAttributes();
        ?>
            <div class="element-row row">
                <div class="element-col col-md-1"><?=$element['id'];?></div>
                <div class="element-col col-md-7"><?=$element['name'];?></div>
                <div class="element-col col-md-2"><?=($element['active'] > 0) ? 'Y' : 'N';?></div>
                <div class="element-col select-col col-md-2">
                    <input type="hidden" name="element_id" value="<?=$element['id'];?>" />
                    <input type="hidden" name="element_name" value="<?=$element['name'];?>" />
                    <button>Выбрать</button>
                </div>
            </div>
        <?} ?>
    </div>
</div>
<script>
    jQuery(document).ready(function(){
        var $ = jQuery;
        $('#find-element-form .elements-list .select-col button').on('click', function() {
            var id = $(this).closest('.select-col').find('input[name=element_id]').val();
            var name = $(this).closest('.select-col').find('input[name=element_name]').val();
            $('.property-input input.searching').val(id).removeClass('searching').parent().find('span.product-name').text(name);
            $('.fancybox-close').click();
        })

    })
</script>
