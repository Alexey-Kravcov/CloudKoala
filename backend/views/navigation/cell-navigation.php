<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\cell\CellType;
use \backend\components\CellNavigation;

?>

<div class="cell-navigation">
    <div class="navigation-tree">
        <div class="top-level">
            <?= Html::a('Данные', Url::to(['index']) );?>
        </div>
        <div class="navigation-level type-level">
            <?foreach($cellTypeModels as $typeModel) { 
                if($mode == 'service') echo CellNavigation::getServiceTypeRow($typeModel);
                    elseif($mode == 'content') echo CellNavigation::getContentTypeRow($typeModel);
            }?>
        </div>
    </div>
    <?
    //dump($cellTypeModels);
    ?>

</div>
