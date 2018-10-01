<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\components\ComponentList */

$this->title = 'Create Component List';
$this->params['breadcrumbs'][] = ['label' => 'Component Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="component-list-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
