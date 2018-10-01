<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use common\models\main\MainSettings;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Параметры';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="main-settings-index">

    <p>
        <?= Html::a('Новый параметр', ['setting-create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
            'code',
            'value',

            [   'class' => 'yii\grid\ActionColumn',
                'template' => "{update} {delete}",
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::to(['setting-update', 'id'=>$model->id]) );
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::to(['setting-delete', 'id'=>$model->id]) );
                    }
                ],
                'visibleButtons' => [
                    'delete' => function ($model, $key, $index) {
                        if($model->code == 'SiteName' || $model->code == 'AdminEmail' || $model->code == 'templateName') return false;
                            else return true;
                    }
                ]


            ],
        ],
    ]); ?>
</div>
<?php
    \yii\helpers\Url::remember('main-settings');
?>
