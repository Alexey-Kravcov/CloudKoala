<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\cell\CellType */

$this->title = 'Создание типа ячейки';
$this->params['breadcrumbs'][] = ['label' => 'Типы ячеек', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cell-type-create">

    <?= $this->render('_form_type', [
        'model' => $model,
    ]) ?>

</div>
