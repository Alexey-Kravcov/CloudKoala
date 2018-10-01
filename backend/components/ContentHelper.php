<?php

namespace backend\components;

use Yii;
use common\models\cell\CellSection;

class ContentHelper {


    public static function getBreadsCrumb($sectionID = 0)
    {
        $path = [];
        if ($sectionID > 0) {
            $currentSection = intval($sectionID);
        } else {
            $currentSection = intval(Yii::$app->request->get('section_id'));
        }
        if ($currentSection > 0) {
            $query = ProductSection::find()->where(['id' => $currentSection])->one();
            $sectionData = $query->getAttributes();
            $path[] = $sectionData;
            if ($sectionData['depth'] > 0) {
                $parent = $sectionData['parent'];
                for ($i = 0; $i < ($sectionData['depth']); $i++) {
                    $query = ProductSection::find()->where(['id' => $parent])->one();
                    $data = $query->getAttributes();
                    $path[] = $data;
                    $parent = $data['parent'];
                }
            }
            return array_reverse($path);
        }
    }

    public static function getSectionTreeArray($cellID) {
        $arSections = [];
        $links = [];
        $tree = [];
        $sections = CellSection::find()
            ->andFilterWhere(['cell_id'=>$cellID])
            ->all();
        foreach($sections as $section) {
            $attr = $section->getAttributes();
            $arSections[$attr['id']] = $attr;
            $arSections[] = $attr;
        }
        for( $q = 0; $q <= (count( $arSections )+1); $q++ ) {
            $elem = $arSections[$q];
            if( $elem['parent'] === 0 ) {
                $tree[$elem['id']] = $elem;
                $links[$elem['id']] = &$tree[$elem['id']];
            } else {
                $links[$elem['parent']]['childrens'][$elem['id']] = $elem;
                $links[$elem['id']] = &$links[$elem['parent']]['childrens'][$elem['id']];
            }
        }
        return $tree;
    }

    public static function getOptionTag($section, $current_id=0) {
        $prefix = str_repeat(' - ', $section['depth']);
        $select = ($section['id'] == $current_id) ? 'selected' : '';
        $string = '<option value="'.$section['id'].'" '.$select.' >'. $prefix .$section['name'].'</option>';
        if(count($section['childrens']) > 0) {
            foreach($section['childrens'] as $subsection) {
                $string .= self::getOptionTag($subsection, $current_id);
            }
        }
        return $string;
    }

}