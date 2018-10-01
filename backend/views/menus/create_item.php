<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\menu\MenuItem */

$this->title = 'Создание пункта меню';
$this->params['breadcrumbs'][] = ['label' => 'Список меню', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-item-create">

    <?= $this->render('_form_item', [
        'model' => $model,
        'items' => $items,
    ]) ?>

</div>
