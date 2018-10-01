<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel common\models\menu\MenuItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Типы меню';
$this->params['breadcrumbs'][] = $this->title;
?>

    <div class="row">
        <div class="col-md-2">
            <?= Html::a('Создать меню', ['create-menu'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="col-md-2">
            <?= Html::a('Создать пункт меню', ['create-item'], ['class' => 'btn btn-info']) ?>
        </div>
    </div>

<div class="menu-item-index data-list edit-form">
    <div id="tabs">
    <ul>
        <?foreach($menuModels as $k=>$model) { ?>
            <li><a href="#menu-tab<?=$k+1;?>"><?=$model['menu']['name'];?></a></li>
        <?}?>
    </ul>
    <?foreach($menuModels as $k=>$model) { ?>
        <div  id="menu-tab<?=$k+1;?>">
            <div class="row">
                <div class="menu-description col-md-10">
                    <?=$model['menu']['description'];?>
                </div>
                <div class="menu-prop-button">
                    <?=Html::a('Свойства меню', ['update-group', 'id'=>$model['menu']['id']], ['class'=>'btn btn-primary']); ?>
                </div>
            </div>
            <div class="menu-form-container">
               <?php $form = ActiveForm::begin([
                    'id' => 'content-menu-form',
                ]); ?>
                    <div class="row menu-items-block">
                        <div class="target-menu">
                            <h4>Состав меню</h4>
                            <ul id="sortable-target" class="connectedSortable">
                                <?
                                $arrItem = [];
                                $i = 1;
                                foreach($model['items'][$model['menu']['id']] as $k=>$item) {
                                    $arrItem[] = $item['menu_item'];
                                    ?>
                                    <li class="ui-state-default">
                                        <?=$menuItems[$item['menu_item']]->name;?>
                                        <?=Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::to(['update-item', 'id'=>$menuItems[$item['menu_item']]->id]), ['class'=>'fl-right edit-button']);?>
                                        <? // dump($item);?>
                                        <?=Html::hiddenInput('menu['.$i.'][menu_id]', $item['menu_group']);?>
                                        <?=Html::hiddenInput('menu['.$i.'][item_id]', $menuItems[$item['menu_item']]->id);?>
                                        <?//=Html::hiddenInput('menu['.$i.'][position]', $i);?>
                                    </li>
                                    <?  $i++;
                                }?>
                            </ul>
                        </div>
                        <div class="icon-block">
                            <span class="fa fa-exchange"></span>
                        </div>
                        <div class="source-menu">
                            <h4>Пункты для меню</h4>
                            <ul id="sortable-source" class="connectedSortable">
                                <?foreach($menuItems as $item) { //dump($model);
                                    if(in_array($item->id, $arrItem)) continue;
                                    ?>
                                    <li class="ui-state-default">
                                        <?=$item->name;?>
                                        <?=Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update-item', ['id'=>$item->id]], ['class'=>'fl-right edit-button']);?>
                                        <?=Html::hiddenInput('menu['.$i.'][menu_id]', $model['menu']['id']);?>
                                        <?=Html::hiddenInput('menu['.$i.'][item_id]', $item->id);?>
                                        <?//=Html::hiddenInput('menu['.$i.'][position]', $i);?>
                                    </li>
                                    <?  $i++;
                                }?>
                            </ul>
                            <?//=dump($model['items']); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= Html::submitButton((Yii::$app->request->get('id') > 0)? 'Обновить' : 'Добавить', ['class' => 'btn btn-primary']) ?>
                        <?= Html::input('hidden', 'apply', 0 ); ?>
                        <?= Html::button('Применить', ['class' => 'btn btn-info apply-button']) ?>
                        <?= Html::a('Отмена', \yii\helpers\Url::previous(), ['class' => 'btn btn-default']) ?>
                    </div>
                <?php $form = ActiveForm::end(); ?>
            </div>
        </div>
    <?}?>
</div>

<?
Url::remember();
?>