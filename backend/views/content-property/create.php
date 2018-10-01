<?php

use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model common\models\cell\CellProperty */

$this->title = 'Создание свойства '.$type.' ячейки "'.$model->cellItem->name.'"';
$this->params['breadcrumbs'][] = ['label' => 'Свойства ячейкм', 'url' => Url::previous('edit-cell')];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cell-property-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
