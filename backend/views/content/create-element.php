<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\cell\CellElement */

$itemModel = $model->getCell()->one();
$this->title = 'Создать '.$itemModel->element_name;
$this->params['breadcrumbs'][] = ['label' => 'Cell Elements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->title = 'Создание '.$itemModel->element_name.' в ячейке "'.$itemModel->name.'"';
?>
<div class="cell-element-create">

    <?= $this->render('_form_element', [
        'model' => $model,
        'seoModel' => $seoModel,
        'imageModel' => $imageModel,
        'hasSections' => $hasSections,
        'preview' => [],
        'detail' => [],
        'arProperties' => $arProperties,
    ]) ?>

</div>
