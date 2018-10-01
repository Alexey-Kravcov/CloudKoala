<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\pages\PageList */

$this->title = 'Update Page List: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Page Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="page-list-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
