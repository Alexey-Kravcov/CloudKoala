<?php

use yii\helpers\Html;
use backend\components\ProductHelper;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model backend\models\product\ProductSection */
if($type == 'element') $name = "элемента";
    else $name = "раздела";


$this->title = 'Создание свойства '.$name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="property-create">

    <?= $this->render('_form_property', [
        'model' => $model,
        'type' => $type,
    ]) ?>

</div>