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

$this->title = $currentCellModel->elements_name;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="product-section-index">
    <? $path = ProductHelper::getBreadsCrumb(); ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?
        $currentTypeModel = $currentCellModel->cellType;
        if($currentTypeModel->sections > 0) { ?>
            <?= Html::a('Создать '.$currentCellModel->sections_name, Url::toRoute(['content/create-section/', 'cell_id'=> $currentCellModel->id, 'section_id'=>Yii::$app->request->get('section_id'), 'depth'=>Yii::$app->request->get('depth')]), ['class' => 'btn btn-success']) ?>
        <? } ?>
        <?if($currentTypeModel->sections < 1 || ($currentTypeModel->sections > 0 && Yii::$app->request->get('section_id') > 0) ) { ?>
            <?= Html::a('Создать '.$currentCellModel->elements_name, Url::toRoute(['content/create-element/', 'cell_id'=> $currentCellModel->id, 'section_id'=>Yii::$app->request->get('section_id'), 'depth'=>Yii::$app->request->get('depth')]),  ['class' => 'btn btn-success']) ?>
        <? } ?>
    </p>

    <div class=""browser-block">

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
                Автор
            </div>
            <div class="time-update col-md-1">
                Изменено
            </div>
            <div class="time-create col-md-1">
                Создано
            </div>
        </div>
        <?
        // dump($sectionModels);
        /*
        $models2 = $doubleProvider->getModels();
        $models = $models2['sections'];*/
        foreach($sectionModels as $model) {
            //echo "<pre>";print_r($model->getAttributes()); echo "</pre>";
            $row = $model->getAttributes(); // dump($row);?>
            <div class="row section">
                <div class="title col-md-4">
                    <div class="icon col-md-2">
                        <i class="fa fa-folder"></i>
                    </div>
                    <div class="icon col-md-10">
                        <?= Html::a( $row['name'], Url::toRoute( ['content/index-content/', 'id'=>$row['cell_type_id'], 'cell_id'=>$row['cell_id'], 'section_id'=>$row['id'], 'depth'=>($row['depth']+1) ]) ) ?>
                    </div>
                </div>
                <div class="edit col-md-1">
                    <?= ($row['active'] > 0) ? "Да" : "Нет"; ?>
                </div>
                <div class="edit col-md-1">
                    <?= Html::a( '<i class="fa fa-edit"></i>', Url::toRoute( ['content/update-section/', 'section_id'=>$row['id'] ]) ) ?>
                </div>
                <div class="del col-md-1">
                    <?= Html::a( '<i class="fa fa-trash"></i>', Url::toRoute( ['content/delete-section/', 'id'=>$row['id'] ]) ) ?>
                </div>
                <div class="author col-md-1">
                    <?= Html::a( $model->getUser()->one()->name, Url::toRoute( ['users/view/', 'id'=>$row['user_id'] ]) ) ?>
                </div>
                <div class="time-update col-md-1">
                    <?= date('d-m-Y', $row['updated_at']); ?><br>
                    <?= date('H:i:s', $row['updated_at']); ?>
                </div>
                <div class="time-create col-md-1">
                    <?= date('d-m-Y', $row['created_at']); ?><br>
                    <?= date('H:i:s', $row['created_at']); ?>
                </div>
            </div>
        <?  }
        foreach($elementModels as $model) {
            //echo "<pre>";print_r($model->getAttributes()); echo "</pre>";
            $row = $model->getAttributes(); ?>
            <div class="row element">
                <div class="title col-md-4">
                    <div class="icon col-md-2">
                        <i class="fa fa-shopping-basket"></i>
                    </div>
                    <div class="icon col-md-10">
                        <?= Html::a( $row['name'], Url::toRoute( ['content/update-element/', 'element_id'=>$row['id']] ) ) ?>
                    </div>
                </div>
                <div class="edit col-md-1">
                    <?= ($row['active'] > 0) ? "Да" : "Нет"; ?>
                </div>
                <div class="edit col-md-1">
                </div>
                <div class="del col-md-1">
                    <?= Html::a( '<i class="fa fa-trash"></i>', Url::toRoute( ['content/delete-element/', 'id'=>$row['id'] ]) ) ?>
                </div>
                <div class="author col-md-1">
                    <?= Html::a( $model->getUser()->one()->name, Url::toRoute( ['users/view/', 'id'=>$row['user_id'] ]) ) ?>
                </div>
                <div class="time-update col-md-1">
                    <?= date('d-m-Y', $row['updated_at']); ?><br>
                    <?= date('H:i:s', $row['updated_at']); ?>
                </div>
                <div class="time-create col-md-1">
                    <?= date('d-m-Y', $row['created_at']); ?><br>
                    <?= date('H:i:s', $row['created_at']); ?>
                </div>
            </div>
        <?  }
            if(count($sectionModels) == 0 && count($elementModels) == 0) { ?>
                <div class="row empty-content center">
                    <h4>Раздел пуст</h4>
                </div>
            <?}  ?>
    </div>
    <div class="pager-block">
        <?//=  LinkPager::widget([ 'pagination' => $doubleProvider->getPagination(), ]); ?>
    </div>
</div>
<?
Url::remember();
?>

</div>
