<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\product\ProductElementSearchModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Product Elements';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-element-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Product Element', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            //'code',
            'active',
            //'sort',
            // 'section_id',
            // 'user_id',
            // 'preview_picture',
            // 'preview_text',
            // 'detail_picture',
            // 'detail_text',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
