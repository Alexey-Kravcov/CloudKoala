<?php

use yii\helpers\Html;
use backend\components\ProductHelper;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model backend\models\product\ProductSection */

$this->title = 'Создание категории товаров ';
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-section-create">

    <?php
        $path = ProductHelper::getBreadsCrumb($model->parent);
    ?>
    <div class="product-chain">
        <ul class="list-inline">
            <li>
                <?= Html::a('Товары', Url::toRoute(['product/index/']) ) ?>
            </li>
            <?if(count($path)>0) {
                foreach($path as $item) {?>
                <li>
                    <?= Html::a($item['name'], Url::toRoute(['product/index/', 'section_id'=>$item['id'], 'depth'=>($item['depth']+1) ]) ) ?>
                </li>
            <?  }
            }?>
        </ul>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
        'images' => $images,
        'preview' => $preview,
        'seo' => $seo,
        'properties' => $properties,
    ]) ?>

</div>
