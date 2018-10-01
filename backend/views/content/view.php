<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\cell\CellSection */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Cell Sections', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cell-section-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'code',
            'depth',
            'parent',
            'cell_type_id',
            'cell_id',
            'preview_picture',
            'preview_text:ntext',
            'active',
            'sort',
            'user_id',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
