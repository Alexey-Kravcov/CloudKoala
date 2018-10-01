<?php

use yii\helpers\Html;
use backend\components\ProductHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\product\ProductSection */

$this->title = 'Обновление каталога товаров: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Product Sections', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-section-update">
    <?php
    $path = ProductHelper::getBreadsCrumb($model->id);
    //dump($path); die();
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

    <?= $this->render('_form', [
        'model' => $model,
        'images' => $images,
        'preview' => $preview,
        'seo' => $seo,
        'properties' =>$properties,
        'propValue' => $propValue,
        'listEnums' => $listEnums,
    ]) ?>

</div>
