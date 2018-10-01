<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\prices\Price */

$this->title = 'Обновление цены: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Цены', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="price-update">

    <?= $this->render('_form', [
        'model' => $model,
        'buyers' => $buyers,
    ]) ?>

</div>
