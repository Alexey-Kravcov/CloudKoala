<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\users\ProfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Права ролей';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="user-info permissions-role">

        <div class="row head">
            <div class="col-md-2">
                Роль
            </div>
            <div class="col-md-6">
                Права
            </div>
            <div class="col-md-2">

            </div>
            <div class="col-md-1">

            </div>
        </div>
        <?
        foreach($permissions as $role=>$permission) {
            $access = [];
            foreach($permission as $key=>$v){
                $access[] = $key;
            }
            ?>
            <div class="row">
                <div class="col-md-2">
                    <?=$role;?>
                </div>
                <div class="col-md-5 permission-list">
                    <?= Html::hiddenInput('rolename', $role);?>
                    <? //dump($access);
                    foreach($list as $perm) { ?>
                        <div class="permission-row">
                            <div class="col-md-3">
                                <?= $perm->name;?>
                            </div>
                            <div class="col-md-8">
                                <?=$perm->description;?>
                            </div>
                            <div class="col-md-1">
                                <?= Html::checkbox($perm->name, (in_array($perm->name, $access)) ? true : false, ['value'=> (in_array($perm->name, $access)) ? 1 : 0]); ?>
                            </div>
                        </div>
                    <?} ?>
                    
                </div>
                <div class="col-md-2 condition">

                </div>
                <div class="col-md-1">
                    
                </div>
            </div>
        <?  } ?>
    </div>

    <p>
        <!-- <?= Html::a('Create Profile', ['create'], ['class' => 'btn btn-success']) ?> -->
    </p>

</div>