<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\cell\CellTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Контент сайта';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="cell-edit-content">
        <div class="cell-left-part cell-part">
            <?= $this->render(
                Yii::getAlias('../navigation/cell-navigation'),
                [   'cellTypeModels' => $cellTypeModels,
                    'mode' => 'content',
                ]
            ) ?>
        </div>
        <div class="cell-right-part cell-part">
            <?= $this->render('index-'.$template,
                [   'dataProvider'=>$dataProvider,
                    'seoModel' => $seoModel,
                    'sectionModels' => $sectionModels,
                    'elementModels' => $elementModels,
                    'cellTypeModels' => $cellTypeModels,
                    'currentCellModel' => $currentCellModel,
                    'type_id' => $type_id,
                ]) ?>
        </div>
    </div>
<?php
Url::remember();
?>