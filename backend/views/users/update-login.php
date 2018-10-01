<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\users\Profile */

$this->title = 'Обновление учетной записи: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="profile-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_login', [
        'model' => $model,
    ]) ?>

</div>