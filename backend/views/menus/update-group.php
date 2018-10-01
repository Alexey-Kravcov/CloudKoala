<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\menu\MenuItem */

$this->title = 'Редактирование меню: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Menu Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="menu-item-update">

    <?= $this->render('_form_group', [
        'model' => $model,
    ]) ?>

</div>
