<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\product\ProductProperty */

$this->title = 'Обновление свойства товара: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Свойства товара', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновление';
?>
<div class="product-property-update">

    <?= $this->render('_form_property', [
        'model' => $model,
        'propEnum' => $propEnum,
    ]) ?>

</div>
