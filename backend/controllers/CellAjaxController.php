<?php

namespace backend\controllers;

use backend\components\CellNavigation;
use common\models\cell\CellItem;
use common\models\cell\CellSection;
use \Yii;
use yii\helpers\Html;
use yii\helpers\Url;

class CellAjaxController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    /*
     * navigation actions
     */

    public function actionGetCellItems() {

        $typeID = Yii::$app->request->post('type_id');
        $mode = Yii::$app->request->post('mode');
        $itemModels = self::getItemModels($typeID, true);
        $row = '';
        if(count($itemModels) > 0) {
            foreach ($itemModels as $itemModel) {
                if($mode == 'service') $row .= CellNavigation::getServiceItemRow($itemModel);
                    else $row .= CellNavigation::getContentItemRow($itemModel);
            }
        } else $row = "Ячейки отсутствуют";
        return $row;
        //dump($itemModels);
    }

    /*
     * property actions
     */
    public function actionPropertyItemsSelect() {
        $typeID = Yii::$app->request->post('type_id');
        $arItems = self::getItemModels($typeID);
        if(count($arItems) < 1) {
            $arItems = [''=>'...'];
        }
        $row = Html::dropDownList('link-property-setting[cell-item]', '', $arItems, ['class'=>'select-input cell-item-select' ] );
        //dump($itemModels);
        return $row;
    }

    public function actionPropertySectionsSelect() {
        $itemID = Yii::$app->request->post('item_id');
        $arSections = self::getSectionModels($itemID);
        if(count($arSections)< 1) {
            $arSections = [''=>'...'];
        }
        $row = Html::dropDownList('link-property-setting[cell-section]', '', $arSections, ['class'=>'select-input cell-section-select' ] );
        return $row;
    }




    public function getItemModels($typeID, $object = false) {
        $itemModels = CellItem::find()
            ->where(['cell_type_id' => $typeID])
            ->all();
        if($object) return $itemModels;
        if(count($itemModels) > 0) {
            $arItems = [''=>'Выберите ячейку'];
            foreach($itemModels as $model){
                $arItems[$model->id] = $model->name;
            }
            return $arItems;
        } else return false;
    }

    public function getSectionModels($itemID) {
        $sectionModels = CellSection::find()
            ->where(['cell_id' => $itemID])
            ->all();
        if(count($sectionModels) > 0) {
            $arSections = [''=>'Выберите раздел'];
            foreach($sectionModels as $model){
                $arSections[$model->id] = $model->name;
            }
            return $arSections;
        } else return false;
    }
}
