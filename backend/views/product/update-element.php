<?php

use yii\helpers\Html;
use backend\components\ProductHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\product\ProductSection */

$this->title = 'Редактирование товара: ' . $model->name ;

?>
<div class="product-section-update">
    <?php
        $path = ProductHelper::getBreadsCrumb($model->section_id);
    ?>
    <div class="product-chain">
        <ul class="list-inline">
            <li>
                <?= Html::a('Товары', Url::toRoute(['product/index/']) ) ?>
            </li>
            <?foreach($path as $item) {?>
                <li>
                    <?= Html::a($item['name'], Url::toRoute(['product/index/', 'section_id'=>$item['id'], 'depth'=>($item['depth']+1) ]) ) ?>
                </li>
            <?}?>
        </ul>
    </div>

    <?= $this->render('_form_element', [
        'model' => $model,
        'images' => $images,
        'preview' => $preview,
        'detail' => $detail,
        'seo' => $seo,
        'properties' =>$properties,
        'propValue' => $propValue,
        'listEnums' => $listEnums,
    ]) ?>

</div>
