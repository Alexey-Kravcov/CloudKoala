<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\cell\CellTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Типы ячеек';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cell-edit-content">
    <div class="cell-left-part cell-part">
        <?= $this->render(
            '../navigation/cell-navigation',
            ['cellTypeModels' => $cellTypeModels,
             'mode' => 'service',
            ]
        ) ?>
    </div>
    <div class="cell-right-part cell-part">
        <?= $this->render('index-'.$template,
            ['dataProvider'=>$dataProvider,
            'searchModel'=>$searchModel,
            'type_id' => $type_id,
            ]) ?>
    </div>
</div>
<?php
Url::remember();
?>