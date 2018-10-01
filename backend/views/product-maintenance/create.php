<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\product\ProductProperty */

$this->title = 'Создание свойства товара:';
$this->params['breadcrumbs'][] = ['label' => 'Свойство товара', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-property-create">

    <?= $this->render('_form_property', [
        'model' => $model,
    ]) ?>

</div>
