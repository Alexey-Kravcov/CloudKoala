<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\main\MainSettings */

$this->title = 'Обновление параметра: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Параметры', 'url' => ['settings']];
$this->params['breadcrumbs'][] = 'Обновление';
?>
<div class="main-settings-update">

    <?= $this->render('_form_settings', [
        'model' => $model,
    ]) ?>

</div>
