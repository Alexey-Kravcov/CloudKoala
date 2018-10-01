<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\users\ProfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Роли пользователей';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- <pre><? print_r($users);?> </pre> -->
    <div class="user-info roles-list">
        <?php
        $arRoles = array();
        foreach($roles as $role) {
            $arRoles[$role['name']] = $role['name'];
        }?>
        <div class="row head">
            <div class="col-md-2">
                Логин
            </div>
            <div class="col-md-3">
                E-mail
            </div>
            <div class="col-md-2">
               Роль в системе
            </div>
            <div class="col-md-1">
                Изменить
            </div>
        </div>
<?
        foreach($users as $user) { ?>
            <div class="row">
                <div class="col-md-2">
                    <?=$user['username'];?>
                </div>
                <div class="col-md-3">
                    <?=$user['email'];?>
                </div>
                <div class="col-md-2">
                    <?= Html::dropDownList('role', $user['item_name'], $arRoles); ?>
                    <?= Html::hiddenInput('username', $user['id']);?>
                </div>
                <div class="col-md-1">
                    <?=Html::a('<i class="fa fa-edit"></i>', Url::toRoute(['users/update-login', 'id'=> $user['id']]));?>
                </div>
            </div>
    <?  } ?>
    </div>

    <p>
       <!-- <?= Html::a('Create Profile', ['create'], ['class' => 'btn btn-success']) ?> -->
    </p>

</div>
