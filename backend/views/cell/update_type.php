<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\cell\CellType */

$this->title = 'Обновление типа: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Типы ячеек', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновление';
?>
<div class="cell-type-update">

    <?= $this->render('_form_type', [
        'model' => $model,
    ]) ?>

</div>
