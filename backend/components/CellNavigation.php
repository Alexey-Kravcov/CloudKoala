<?php

namespace backend\components;

use common\models\cell\CellItem;
use common\models\cell\CellSection;
use \Yii;
use \yii\helpers\Html;
use yii\helpers\Url;


class CellNavigation {

    /*
     * cell type level
     */

    public function getServiceTypeRow($typeModel) {
        $requestID = \Yii::$app->request->get('id');
        $open = '';
        if($typeModel->id == $requestID) {
            $open = 'open';
            $load = ' loaded';
        }
        $row = '<div class="navigation-item type-item '.$open.$load.'" id="type-'.$typeModel->id.'">
                            <span class="nav-icon fa fa-chevron-right"></span>
                            <span class="item-icon fa fa-book"></span>';
        $row .= Html::a($typeModel->name, Url::to(['index-type', 'id'=>$typeModel->id]));
        $row .= Html::hiddenInput('type-id', $typeModel->id);
        $row .= Html::hiddenInput('mode', 'service');
        if($open == 'open') {
            $row .= '<div class="navigation-level sublevel item-level">'.self::getItemList($typeModel->id, 'service').'</div>';
        } else {
            $row .= '<div class="navigation-level sublevel item-level">Ячейки отсутствуют</div>';
        }
        $row .= '</div>';

        return $row;
    }

    public function getContentTypeRow($typeModel) {
        $requestID = \Yii::$app->request->get('id');
        $open = '';
        if($typeModel->id == $requestID) {
            $open = 'open';
            $load = ' loaded';
        }
        $row = '<div class="navigation-item type-item '.$open.$load.'" id="type-'.$typeModel->id.'">
                            <span class="nav-icon fa fa-chevron-right"></span>
                            <span class="item-icon fa fa-book"></span>';
        $row .= '<span class="type-name">'.$typeModel->name.'</span>';
        $row .= Html::hiddenInput('type-id', $typeModel->id);
        $row .= Html::hiddenInput('mode', 'content');
        if($open == 'open') {
            $row .= '<div class="navigation-level sublevel item-level">'.self::getItemList($typeModel->id, 'content').'</div>';
        } else {
            $row .= '<div class="navigation-level sublevel item-level">Ячейки отсутствуют</div>';
        }
        $row .= '</div>';

        return $row;
    }

    /*
     *  cell item level
     */

    public function getItemList($ID, $mode='') {
        $itemModels = CellItem::findAll(['cell_type_id'=>$ID]);
        $row = '';
        if(count($itemModels) > 0) {
            foreach ($itemModels as $itemModel) {
                if($mode == 'service') $row .= self::getServiceItemRow($itemModel);
                    elseif($mode == 'content') $row .= self::getContentItemRow($itemModel);
            }
        } else {
            $row = 'Ячейки отсутствуют';
        }

        return $row;
    }

    public function getServiceItemRow($itemModel) {
        $requestID = \Yii::$app->request->get('item_id');
        $row = '<div class="navigation-item item-item" id="item-'.$itemModel->id.'">
                    <span class="item-icon fa fa-cubes"></span>';
        $row .= Html::a($itemModel->name, Url::to(['cell/update-item', 'id'=>$itemModel->id]));
        $row .= '</div>';

        return $row;
    }

    public function getContentItemRow($itemModel) {
        $requestID = \Yii::$app->request->get('cell_id');
        $open = '';
        if($itemModel->id == $requestID) $open = 'open';
        $row = '<div class="navigation-item item-item '.$open.'" id="item-'.$itemModel->id.'">
                    <span class="nav-icon fa fa-chevron-right"></span>
                    <span class="item-icon fa fa-cubes"></span>';
        $row .= Html::a($itemModel->name, Url::to(['content/index-content', 'id'=>$itemModel->cell_type_id, 'cell_id'=>$itemModel->id ]));
        $row .= Html::hiddenInput('cell-id', $itemModel->id);
        $row .= Html::hiddenInput('depth', '0');
        if($open == 'open') {
            $row .= '<div class="navigation-level sublevel section-level">'.self::getSectionList($itemModel).'</div>';
        } else {
            $row .= '<div class="navigation-level sublevel section-level"><?= $typeModel->sections_name;?> отсутствуют</div>';
        }
        $row .= '</div>';

        return $row;
    }

    /*
     * cell section level
     */

    public function getSectionList($itemModel, $parentID=false) {
        $requestID = \Yii::$app->request->get('section_id');
        $depth = \Yii::$app->request->get('depth') - 1;
        if($parentID) {
            $secModels = CellSection::find()
                ->where(['parent'=>$parentID])
                ->all();
        } else {
            $rootSectionID = $requestID;
            if($depth > 0) {
                for($i=0; $i < $depth; $i++){
                    $section = CellSection::find()
                        ->where(['id'=>$rootSectionID])
                        ->one();
                    $rootSectionID = $section->parent;
                }
            }
            $secModels = CellSection::find()
                ->where(['cell_id'=>$itemModel->id, 'depth'=>0])
                ->all();
            $requestID = $rootSectionID;
        }

        $row = '';
        if(count($secModels) > 0) {
            foreach ($secModels as $model) {
                $open = '';
                if($model->id == $requestID) $open = 'open';
                $row .= '<div class="navigation-item section-item '.$open.'" id="section-'.$model->id.'">
                    <span class="nav-icon fa fa-chevron-right"></span>';
                if($open != '') {
                    $row .= '<span class="item-icon fa fa-folder-open"></span>';
                } else {
                    $row .= '<span class="item-icon fa fa-folder"></span>';
                }
                $row .= Html::a($model->name, Url::to(['content/index-content', 'id'=>$itemModel->cell_type_id, 'cell_id'=>$itemModel->id,
                                                                                'section_id'=>$model->id, 'depth'=>$model->depth+1 ]) );
                $row .= Html::hiddenInput('cell-id', $itemModel->id);
                $row .= Html::hiddenInput('depth', '0');
                if($open == 'open') {
                    $row .= '<div class="navigation-level sublevel section-level">'.self::getSectionList($itemModel, $model->id).'</div>';
                } else {
                    $row .= '<div class="navigation-level sublevel section-level"><?= $typeModel->sections_name;?> отсутствуют</div>';
                }
                $row .= '</div>';
            }
        } else {
            $row = 'Разделы отсутствуют';
        }

        return $row;

    }
}
