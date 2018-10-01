<?php

use \Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use common\models\cell\CellProperty;

/* @var $this yii\web\View */
/* @var $searchModel common\models\cell\CellPropertySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="cell-property-index">

   <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать свойство', Url::to(['content-property/create', 'cell_id'=>Yii::$app->request->get('id'), 'type'=>$type]), ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'code:raw:Код',
            [   'label' => 'Тип',
                'format' => 'text',
                'value' => function($model) {
                    $propertyTypes = CellProperty::getTypeArray();
                    return $propertyTypes[$model->property_type];
                }
            ],
            'active:boolean',
            'sort',
            // 'default_value',
            // 'own',
            'multiple:boolean',
            'filtrable:boolean',
            'required:boolean',
            'description:boolean',

            [   'class' => 'yii\grid\ActionColumn',
                'controller' => 'content-property',
                'template' => "{update} {delete}",
            ],
        ],
    ]); ?>
</div>
<?php
Url::remember('', 'edit-cell');
?>