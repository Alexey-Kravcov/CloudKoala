<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\product\ProductElement */

$this->title = 'Update Product Element: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Product Elements', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-element-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
