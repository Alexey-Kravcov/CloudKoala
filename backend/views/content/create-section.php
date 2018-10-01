<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\cell\CellSection */
$itemModel = $model->getCell()->one();
$this->title = 'Создание '.$itemModel->sections_name;
$this->params['breadcrumbs'][] = ['label' => $model->getCell()->one()->sections_name, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->title = 'Создание '.$itemModel->sections_name.' в ячейке "'.$itemModel->name.'"';
?>
<div class="cell-section-create">

    <?= $this->render('_form_section', [
        'model' => $model,
        'seoModel' => $seoModel,
        'imageModel' => $imageModel,
        'preview' => $preview,
        'arProperties'=> $arProperties,
    ]) ?>

</div>
