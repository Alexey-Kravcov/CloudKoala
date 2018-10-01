<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\cell\CellProperty */

$this->title = 'Обновление свойства: ' . $model->name.' ячейки "'.$model->cellItem->name.'"';
$this->params['breadcrumbs'][] = ['label' => 'Cell Properties', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cell-property-update">

    <?= $this->render('_form', [
        'model' => $model,
        'propEnum' => $propEnum,
    ]) ?>

</div>
