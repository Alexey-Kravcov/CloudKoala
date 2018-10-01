<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\cell\CellItem */

$this->title = 'Обновление ячейки: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Типы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновление';
?>
<div class="cell-item-update">

    <?= $this->render('_form_item', [
        'model' => $model,
    ]) ?>

</div>

<?
Url::remember('cell-update-item');
?>