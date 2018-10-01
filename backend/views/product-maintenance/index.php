<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\product\ProductPropertySearchModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Свойства товара';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-property-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать свойство товара', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'code',
            'active',
            // 'sort',
            // 'default_value',
             'property_type',
             'implement',
             'multiple',
             'filtrable',
             'required',
            // 'description',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?
    Url::remember();
    ?>

</div>
