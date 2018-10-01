<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\cell\CellElement */

$this->title = 'Редактирование : ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Cell Elements', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cell-element-update">

    <?= $this->render('_form_element', [
        'model' => $model,
        'seoModel' => $seoModel,
        'imageModel' => $imageModel,
        'preview' => $preview,
        'detail' => $detail,
        'arProperties'=> $arProperties,
    ]) ?>

</div>
