<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use common\models\product\ProductSection;
use backend\components\ProductHelper;


/* @var $this yii\web\View */
/* @var $searchModel common\models\product\ProductSectionSearchModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Товары';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="product-section-index">
    <?php
        $path = ProductHelper::getBreadsCrumb();
    ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать категорию товара', Url::toRoute(['product/create-category/', 'depth'=>Yii::$app->request->get('depth'), 'parent'=>Yii::$app->request->get('section_id')]), ['class' => 'btn btn-success']) ?>
        <? if(Yii::$app->request->get('depth') > 0) { ?>
            <?= Html::a('Создать товар', Url::toRoute(['product/create-element/', 'section_id'=>Yii::$app->request->get('section_id'), 'depth'=>Yii::$app->request->get('depth')]), ['class' => 'btn btn-success']) ?>
        <? } ?>
    </p>

    <div class=""browser-block">
        <div class="product-chain">
            <ul class="list-inline">
                <li> <?= Html::a('Товары', Url::toRoute(['product/index/']) ) ?> </li>
                <?if(count($path) > 0) {
                    foreach ($path as $item) { ?>
                        <li> <?= Html::a($item['name'], Url::toRoute(['product/index/', 'section_id' => $item['id'], 'depth' => ($item['depth'] + 1)])) ?> </li>
                <?  }
                } ?>
            </ul>
        </div>
        <div class="structure-table">
            <div class="row head">
                <div class="title col-md-4">
                    <div class="icon col-md-2">Тип</div>
                    <div class="title col-md-10">Наименование</div>
                </div>
                <div class="edit col-md-1">
                    Активность
                </div>
                <div class="edit col-md-1">
                    Изменить
                </div>
                <div class="del col-md-1">
                    Удалить
                </div>
                <div class="author col-md-1">
                    Автор изменений
                </div>
                <div class="time-update col-md-2">
                    Изменено
                </div>
                <div class="time-create col-md-2">
                    Создано
                </div>
            </div>
            <?
                $models2 = $doubleProvider->getModels();
                $models = $models2['sections'];
                foreach($models as $model) {
                    //echo "<pre>";print_r($model->getAttributes()); echo "</pre>";
                    $row = $model->getAttributes(); ?>
                    <div class="row section">
                        <div class="title col-md-4">
                            <div class="icon col-md-2">
                                <i class="fa fa-folder"></i>
                            </div>
                            <div class="icon col-md-10">
                                <?= Html::a( $row['name'], Url::toRoute( ['product/index/', 'section_id'=>$row['id'], 'depth'=>($row['depth']+1) ]) ) ?>
                            </div>
                        </div>
                        <div class="edit col-md-1">
                            <?= ($row['active'] > 0) ? "Да" : "Нет"; ?>
                        </div>
                        <div class="edit col-md-1">
                            <?= Html::a( '<i class="fa fa-edit"></i>', Url::toRoute( ['product/update/', 'id'=>$row['id'] ]) ) ?>
                        </div>
                        <div class="del col-md-1">
                            <?= Html::a( '<i class="fa fa-trash"></i>', Url::toRoute( ['product/delete/', 'id'=>$row['id'] ]) ) ?>
                        </div>
                        <div class="author col-md-1">
                            <?= Html::a( $row['user_id'], Url::toRoute( ['users/view/', 'id'=>$row['user_id'] ]) ) ?>
                        </div>
                        <div class="time-update col-md-2">
                            <?= date('d-m-Y H:i:s', $row['updated_at']); ?>
                        </div>
                        <div class="time-create col-md-2">
                            <?= date('d-m-Y H:i:s', $row['created_at']); ?>
                        </div>
                    </div>
            <?  }
            $models = $models2['elements'];
            foreach($models as $model) {
                //echo "<pre>";print_r($model->getAttributes()); echo "</pre>";
                $row = $model->getAttributes(); ?>
                <div class="row element">
                    <div class="title col-md-4">
                        <div class="icon col-md-2">
                            <i class="fa fa-shopping-basket"></i>
                        </div>
                        <div class="icon col-md-10">
                            <?= Html::a( $row['name'], Url::toRoute( ['product/update/', 'element_id'=>$row['id'] ]) ) ?>
                        </div>
                    </div>
                    <div class="edit col-md-1">
                        <?= ($row['active'] > 0) ? "Да" : "Нет"; ?>
                    </div>
                    <div class="edit col-md-1">
                    </div>
                    <div class="del col-md-1">
                        <?= Html::a( '<i class="fa fa-trash"></i>', Url::toRoute( ['product/delete-element/', 'id'=>$row['id'] ]) ) ?>
                    </div>
                    <div class="author col-md-1">
                        <?= Html::a( $row['user_id'], Url::toRoute( ['users/view/', 'id'=>$row['user_id'] ]) ) ?>
                    </div>
                    <div class="time-update col-md-2">
                        <?= date('d-m-Y H:i:s', $row['updated_at']); ?>
                    </div>
                    <div class="time-create col-md-2">
                        <?= date('d-m-Y H:i:s', $row['created_at']); ?>
                    </div>
                </div>
            <?  } ?>
        </div>
        <div class="pager-block">
            <?=  LinkPager::widget([ 'pagination' => $doubleProvider->getPagination(), ]); ?>
        </div>
    </div>
<?
    Url::remember();
?>

</div>

