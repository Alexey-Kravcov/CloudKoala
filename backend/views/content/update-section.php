<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\cell\CellSection */

$this->title = 'Редактирование раздела: "' . $model->name .'" ячейки "'.$model->cell->name.'"';
$this->params['breadcrumbs'][] = ['label' => 'Cell Sections', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="cell-section-update">

    <?= $this->render('_form_section', [
        'model' => $model,
        'seoModel' => $seoModel,
        'imageModel' => $imageModel,
        'preview' => $preview,
        'arProperties' => $arProperties,
    ]) ?>

</div>
