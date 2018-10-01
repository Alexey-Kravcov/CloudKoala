<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\prices\Price */

$this->title = 'Создание цены';
$this->params['breadcrumbs'][] = ['label' => 'Prices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="price-create">

    <?= $this->render('_form', [
        'model' => $model,
        'buyers' => $buyers,
    ]) ?>

</div>
