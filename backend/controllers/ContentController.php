<?php

namespace backend\controllers;

use common\models\cell\CellProperty;
use common\models\cell\CellPropertyEnum;
use common\models\cell\CellPropertyValue;
use common\models\cell\CellSection;
use common\models\cell\CellElement;
use common\models\cell\CellSeo;
use common\models\cell\CellImages;
use common\models\product\ImagesForm;
use \Yii;
use common\models\cell\CellTypeSearch;
use common\models\cell\CellType;
use common\models\cell\CellItem;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use common\components\FileHelper;
use yii\web\UploadedFile;
use common\models\users\User;

class ContentController extends \yii\web\Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'DeleteSection' => ['POST'],
                    'DeleteElement' => ['POST'],
                ],
            ],
        ];
    }

    /*
     * view action
     */

    public function actionIndex()
    {
        $searchModel = new CellTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $cellTypeModels = CellType::find()
            ->orderBy('sort')
            ->all();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'cellTypeModels' => $cellTypeModels,
            'template' => 'statistic',
        ]);
    }

    public function actionIndexContent()
    {
        $cellID = Yii::$app->request->get('cell_id');
        $sectionID = Yii::$app->request->get('section_id');
        $currentCellModel = CellItem::findOne($cellID);
        $depth = (Yii::$app->request->get('depth') > 0) ? Yii::$app->request->get('depth') : 0;

        $sectionModels = CellSection::find()
            ->where(['cell_id' => $cellID])
            ->andFilterWhere(['depth' => $depth])
            ->andFilterWhere(['parent' => $sectionID])
            ->all();
        $sectionID = ($sectionID > 0) ? $sectionID : '';
        if ($currentCellModel->cellType->sections == 0 || ($currentCellModel->cellType->sections > 0 && $depth > 0)) {
            $elementModels = CellElement::find()
                ->where(['cell_id' => $cellID])
                ->andFilterWhere(['section_id' => $sectionID])
                ->all();
        } else $elementModels = [];
        // dump($elementModels);
        $cellTypeModels = CellType::find()
            ->orderBy('sort')
            ->all();
        // dump($seoModel);
        return $this->render('index', [
            'sectionModels' => $sectionModels,
            'elementModels' => $elementModels,
            'cellTypeModels' => $cellTypeModels,
            'currentCellModel' => $currentCellModel,
            'template' => 'section',
        ]);
    }

    /*
     * create actions
     */
    public function actionCreateSection() {
        $cellID = Yii::$app->request->get('cell_id');

        $model = new CellSection();
        $seoModel = new CellSeo();

        //сохранение данных раздела и Seo раздела
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            CellSeo::savePost($seoModel, $model->id, 'section');
            self::submitForm($model, 'section');
        }

        $imageModel = new ImagesForm();
        $model->depth = (Yii::$app->request->get('depth') > 0) ? Yii::$app->request->get('depth') : 0;
        $model->parent = (Yii::$app->request->get('section_id') > 0) ? Yii::$app->request->get('section_id') : 0;
        $model->cell_id = $cellID;
        $model->cell_type_id = CellItem::findOne($cellID)->getCellType()->one()->id;
        $model->user_id = \Yii::$app->user->identity->id;
        $model->sort = 100;
        $model->active = 1;
        $model->cell_id = $cellID;

        $arProperties = self::getPropertyArray('section', $cellID); 
            return $this->render('create-section', [
                'model' => $model,
                'seoModel' => $seoModel,
                'imageModel' => $imageModel,
                'preview' => [],
                'arProperties' => $arProperties,
            ]);
    }

    public function actionCreateElement($cell_id) {
        //$cellID = Yii::$app->request->get('section_id');
        $hasSections= (CellItem::findOne($cell_id)->getCellType()->one()->sections > 0) ? true : false;

        $model = new CellElement();
        $seoModel = new CellSeo();

        //сохранение данных раздела и Seo раздела
        if ($model->load(Yii::$app->request->post()) ) {
            if($hasSections) $model->section_id = Yii::$app->request->get('section_id');
            $model->save();
            CellSeo::savePost($seoModel, $model->id, 'element');
            self::submitForm($model, 'element');
        }

        $imageModel = new ImagesForm();

        if($hasSections) {
            $model->section_id = Yii::$app->request->get('section_id');
        }

        $model->cell_id = $cell_id;
        $model->cell_type_id = CellItem::findOne($cell_id)->getCellType()->one()->id;
        $model->user_id = \Yii::$app->user->identity->id;
        $model->sort = 100;
        $model->active = 1;

        $arProperties = self::getPropertyArray('element', $cell_id);

        return $this->render('create-element', [
            'model' => $model,
            'seoModel' => $seoModel,
            'imageModel' => $imageModel,
            'hasSections' => $hasSections,
            'preview' => [],
            'detail' => [],
            'arProperties' => $arProperties,
        ]);
    }

    /*
     * update actions
     */
    public function actionUpdateSection($section_id) {

        //получение объектов раздела и Сео
        $model = CellSection::findOne($section_id);
        if (is_object(CellSeo::findOne(['section_id' => $section_id])) ) {
            $seoModel = CellSeo::findOne(['section_id' => $section_id]);
        } else {
            $seoModel = new CellSeo();
        }

        //сохранение данных раздела и Сео раздела
        $date = $_POST['properties']['17'];
        //dump($_POST, true);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            CellSeo::savePost($seoModel, $model->id, 'section');
            CellProperty::savePost($model, 'section');
            self::submitForm($model, 'section');
        }

        //подготовка данных для передачи в шаблон
        $imageModel = new ImagesForm();
        if ($model->preview_picture > 0) {
            $src = FileHelper::getContentPath($model->preview_picture);
            $preview[] = '<img src="/shop' . $src . '" class="preview-thumb" />';
        } else {
            $preview[] = '';
        }

        $arProperties = self::getPropertyArray('section', $model->cell_id, $model->id);

        return $this->render('update-section', [
            'model' => $model,
            'seoModel' => $seoModel,
            'imageModel' => $imageModel,
            'preview' => $preview,
            'arProperties' => $arProperties,
        ]);
    }

    public function actionUpdateElement($element_id) {

        //получение объектов раздела и Сео
        $model = CellElement::findOne($element_id);
        if (is_object(CellSeo::findOne(['element_id' => $element_id])) ) {
            $seoModel = CellSeo::findOne(['element_id' => $element_id]);
        } else {
            $seoModel = new CellSeo();
        }

        //сохранение данных раздела и Сео раздела
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            CellSeo::savePost($seoModel, $model->id, 'element');
            self::submitForm($model, 'element');
        }

        //подготовка данных для передачи в шаблон
        $imageModel = new ImagesForm();
        if ($model->preview_picture > 0) {
            $src = FileHelper::getContentPath($model->preview_picture);
            $preview[] = '<img src="/shop' . $src . '" class="preview-thumb" />';
        } else {
            $preview[] = '';
        }
        if ($model->detail_picture > 0) {
            $src = FileHelper::getContentPath($model->detail_picture);
            $detail[] = '<img src="/shop' . $src . '" class="detail-thumb" />';
        } else {
            $detail[] = '';
        }

        $arProperties = self::getPropertyArray('element', $model->cell_id, $model->id);
        // dump($arProperty, true);

        return $this->render('update-element', [
            'model' => $model,
            'seoModel' => $seoModel,
            'imageModel' => $imageModel,
            'preview' => $preview,
            'detail' => $detail,
            'arProperties' => $arProperties,
        ]);
    }

    /*
     * delete actions
     */

    public function actionDeleteSection($id)
    {
        CellSeo::findOne(['section_id'=>$id])->delete();
        $this->findSectionModel($id)->delete();

        return $this->redirect(Url::previous());
    }

    public function actionDeleteElement($id)
    {
        CellSeo::findOne(['element_id'=>$id])->delete();
        $this->findElementModel($id)->delete();

        return $this->redirect(Url::previous());
    }

    /*
     * find model functions
     */

    private function findSectionModel($id) {
        if ( ($model = CellSection::findOne($id) ) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('По данному запросу ничего не найдено');
        }

    }

    private function findElementModel($id) {
        if ( ($model = CellElement::findOne($id) ) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('По данному запросу ничего не найдено');
        }

    }

    /*
     * other functions
     */

    public function actionImageUpload(){
        if(Yii::$app->request->isPost) {
            $model = new ImagesForm();
            $file = UploadedFile::getInstance($model, 'preview_image' );
            if(!is_object($file)) $file =  UploadedFile::getInstance($model, 'detail_image' );
            if(Yii::$app->request->post('type') == 'section'){
                $path = 'uploads/cells/sections/';
            } elseif(Yii::$app->request->post('type') == 'element') {
                $path = 'uploads/cells/elements/';
            } else {
                return false;
            }
            $file->saveAs(Yii::getAlias('@app').'/../'. $path . md5($file->basename).".".$file->extension);

            $image = new CellImages();
            $image->name = md5($file->basename);
            $image->path= $path;
            $image->extension = $file->extension;
            $image->filesize = $file->size;
            $image->user_id = Yii::$app->user->identity->id;
            $image->save();

            return $image->id;
        }
    }

    /*
     *
     */
    private function getPropertyArray($type, $cellID, $modelID) {
        $arPropertyList = CellProperty::find()
            ->where(['own'=>$type, 'cell_id'=>$cellID])
            ->orderBy('sort')
            ->indexBy('id')
            ->all();
        $arPropertyKeys = array_keys($arPropertyList);
        $arPropValues = CellPropertyValue::getValues($modelID, $arPropertyKeys);
        $arEnums = CellPropertyEnum::getEnumArray($arPropertyKeys);
        $arProperties = compact('arPropertyList', 'arPropValues', 'arEnums');

        return $arProperties;
    }

    /*
     * action of submiting form
     */
    private function submitForm($model, $type) {
        if (!Yii::$app->request->post('apply')) {
            $getData = ['index-content', 'id'=>$model->cell_type_id, 'cell_id'=>$model->cell_id];
            if($type == 'section') {
                if ($model->depth > 0) {
                    $advGetData = ['section_id' => $model->parent, 'depth' => $model->depth];
                    $getData = array_merge($getData, $advGetData);
                }
            }
            if($type == 'element') {
                $advGetData = ['section_id'=>$model->section_id];
                $getData = array_merge($getData, $advGetData);
            if($model->section->depth > 0) {
                $advGetData = ['depth'=>$model->section->depth+1];
                $getData = array_merge($getData, $advGetData);
            }
            }
            return $this->redirect($getData);
        } else {
            return $this->redirect(['update-'.$type, $type.'_id'=>$model->id]);
        }

    }


}

