<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\main\MainSettings */

$this->title = 'Создание параметра';
$this->params['breadcrumbs'][] = ['label' => 'Параметры', 'url' => ['settings']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="main-settings-create">

    <?= $this->render('_form_settings', [
        'model' => $model,
    ]) ?>

</div>
