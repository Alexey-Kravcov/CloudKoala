<?php

use yii\grid\GridView;
use yii\helpers\Html;

?>

<div class="cell-type-index cell-index-block">
    <p>
        <?= Html::a('Создать тип', ['create-type'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'name',
            'code',
            'sections',
            'sort',
            [   'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function($url, $model, $key) {
                        $url = str_replace('update', 'update-type', $url);
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url);
                    }
                ]
            ],
        ],
    ]); ?>
</div>
