<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\components\ComponentList */

$this->title = 'Редактировать компонент: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Список компонентов', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="component-list-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
