<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\cell\CellItem */

$this->title = 'Создание ячейки типа "'.$typeModel->name.'"';
$this->params['breadcrumbs'][] = ['label' => 'Типы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cell-item-create">

    <?= $this->render('_form_item', [
        'model' => $model,
        'typeModel' => $typeModel
    ]) ?>

</div>
