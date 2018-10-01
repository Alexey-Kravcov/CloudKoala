<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="cell-type-index cell-index-block">
    <p>
        <?= Html::a('Создать ячейку', Url::to(['cell/create-item', 'type_id'=>$type_id]), ['class' => 'btn btn-primary']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'emptyText' => 'Ячеек еще не создано.',
        'columns' => [
            'id',
            'name',
            'code',
            'active',
            'sort',
            'searchable',
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:Y-m-d H:i:s']
            ],
            [
                'attribute' => 'updated_at',
                'format' => ['date', 'php:Y-m-d H:i:s']
            ],
            [   'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function($url, $model, $key) {
                        $url = str_replace('update', 'update-item', $url);
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url);
                    },
                    'delete' => function($url, $model, $key) {
                        $url = str_replace('delete', 'delete-item', $url);
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url);
                    }
                ]
            ],
        ],
    ]); ?>
</div>