<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\menu\MenuItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пункты меню';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="menu-item-index data-list">

        <h1><?//= Html::encode($this->title) ?></h1>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <div class="row">
            <div class="col-md-2">
                <?= Html::a('Создать меню', ['create-menu'], ['class' => 'btn btn-success']) ?>
            </div>
            <div class="col-md-2">
                <?= Html::a('Создать пункт меню', ['create-item'], ['class' => 'btn btn-info']) ?>
            </div>
        </div>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                'id',
                'name',
                'code',
                'sort',
                'css_class',
                // 'attributes:ntext',

                [   'class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function($url, $model, $key) {
                            $url = str_replace('update', 'update-item', $url);
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url);
                        }
                    ]
                ],
            ],
        ]); ?>
    </div>

<?
Url::remember();
?>