<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\buyers\BuyerGroup */

$this->title = 'Создание типа(группы) покупателей';
$this->params['breadcrumbs'][] = ['label' => 'Тип покупателей', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="buyer-group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
