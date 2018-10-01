<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 20.04.2017
 * Time: 12:14
 */

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\menu\MenuItem */

$this->title = 'Создание меню';
$this->params['breadcrumbs'][] = ['label' => 'Списки меню', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-item-create">

    <?= $this->render('_form_group', [
        'model' => $model,
    ]) ?>

</div>
