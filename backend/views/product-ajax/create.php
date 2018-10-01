<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\product\ProductElement */

$this->title = 'Create Product Element';
$this->params['breadcrumbs'][] = ['label' => 'Product Elements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-element-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
