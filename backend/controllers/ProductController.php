<?php

namespace backend\controllers;

use common\components\FileHelper;
use backend\components\ProductDataProvider;
use common\models\product\ImagesForm;
use common\models\product\ProductElement;
use common\models\product\ProductImages;
use common\models\product\ProductProperty;
use common\models\product\ProductPropertyEnum;
use common\models\product\ProductPropertyValue;
use common\models\product\ProductSeo;
use Yii;
use common\models\product\ProductSection;
use common\models\product\ProductSectionSearchModel;
use yii\data\ActiveDataProvider;
use yii\data\Sort;
use yii\db\Query;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for ProductSection model.
 */
class ProductController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ProductSection models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query_section = ProductSection::find();
        $query_element = ProductElement::find();

        $provider = new ProductDataProvider([
            'query_section'=> $query_section,
            'query_element'=> $query_element,
            'pagination'=> [
                'pagesize'=> 10,
            ],
            'sort' => [
                'defaultOrder' =>
                    ['sort'=> SORT_DESC]
            ],

        ]);
        // echo "<pre>";print_r(Yii::$app->request->queryParams); echo "</pre>";

        return $this->render('index', [
            'doubleProvider' => $provider,
        ]);
    }

    /**
     * Displays a single ProductSection model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ProductSection model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateCategory()
    {
        $model = new ProductSection();
        $seoModel = new ProductSeo();

        //получение моделей всех свойств типа записи
        $properties = self::getPropertyListArray('section');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->user_id = \Yii::$app->user->identity->id;
            $model->save();
            if($seoModel->load(Yii::$app->request->post()) ) {
                $seoModel->section_id = $model->id;
                $seoModel->save();
            }
            return $this->redirect(['index', 'section_id'=>$model->parent, 'depth'=>$model->depth ]);
        } else {
            $images = new ImagesForm();
            if(Yii::$app->request->get('depth') > 0) {
                $model->depth = intval(Yii::$app->request->get('depth'));
                $model->parent = intval(Yii::$app->request->get('parent'));
            } else {
                $model->depth = 0;
                $model->parent = 0;
            }
            $model->sort = 100;
            $model->active = 1;

            $seo = new ProductSeo();

            return $this->render('create', [
                'model' => $model,
                'images' => $images,
                'preview' => [],
                'seo' => $seo,
                'properties' => $properties,
            ]);
        }
    }

    public function actionCreateElement()
    {
        $model = new ProductElement();
        $seoModel = new ProductSeo();

        //получение моделей всех свойств типа записи
        $properties = self::getPropertyListArray('element');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->user_id = \Yii::$app->user->identity->id;
            $model->save();
            if($seoModel->load(Yii::$app->request->post()) ) {
                $seoModel->element_id = $model->id;
                $seoModel->save();
            }
            if (!Yii::$app->request->post('apply')) {
                $getData = ['index', 'section_id'=>$model->section_id, 'depth'=>Yii::$app->request->get('depth') ];
                return $this->redirect($getData);
            } else {
                return $this->redirect(['update', 'element_id'=>$model->id]);
            }
        } else {
            $images = new ImagesForm();
            $model->section_id = intval(Yii::$app->request->get('section_id'));
            $model->sort = 100;
            $model->active = 1;

            $seo = new ProductSeo();

            return $this->render('create-element', [
                'model' => $model,
                'images' => $images,
                'preview' => [],
                'seo' => $seo,
                'properties' => $properties,
            ]);
        }
    }

    /*
     *
     */
    public function actionPreviewImageUpload(){
        if(Yii::$app->request->isPost) {
            $model = new ImagesForm();
            $file = UploadedFile::getInstance($model, 'preview_image' );
            if(!is_object($file)) $file =  UploadedFile::getInstance($model, 'detail_image' );
            if(Yii::$app->request->post('type') == 'section'){
                $path = 'uploads/products/sections/';
            } elseif(Yii::$app->request->post('type') == 'element') {
                $path = 'uploads/products/elements/';
            } else {
                return false;
            }
            $file->saveAs(Yii::getAlias('@app').'/../'. $path . md5($file->basename).".".$file->extension);

            $image = new ProductImages();
            $image->name = md5($file->basename);
            $image->path= $path;
            $image->extension = $file->extension;
            $image->user_id = Yii::$app->user->identity->id;
            $image->save();

            return $image->id;
        }
    }

    /*
     *
     */
    public function actionPropertyImageUpload(){
        if(Yii::$app->request->isPost) {
            $model = new ImagesForm();
            $varName = Yii::$app->request->post('var');
            $file = UploadedFile::getInstance($model, $varName );
            if(!is_object($file)) $file =  UploadedFile::getInstance($model, 'detail_image' );
            if(Yii::$app->request->post('type') == 'section'){
                $path = 'uploads/products/sections/';
            } elseif(Yii::$app->request->post('type') == 'element') {
                $path = 'uploads/products/elements/';
            } else {
                return false;
            }
            $file->saveAs(Yii::getAlias('@app').'/../'. $path . md5($file->basename).".".$file->extension);

            $image = new ProductImages();
            $image->name = md5($file->basename);
            $image->path= $path;
            $image->extension = $file->extension;
            $image->user_id = Yii::$app->user->identity->id;
            $image->save();

            return $image->id;
        }
    }


    //public function actionUpdateElement()
    public function actionUpdate()
    {
        // установка переменных запроса типа данных
        if (Yii::$app->request->get('element_id') > 0) {
            $type = "element";
            $typeOwn = 'E';
        } elseif (Yii::$app->request->get('id') > 0) {
            $type = "section";
            $typeOwn = 'S';
        }

        // получение объекта элемента и SEO объекта
        if ($type == 'element') {
            $model = ProductElement::findOne(Yii::$app->request->get('element_id'));
            if (is_object(ProductSeo::findOne(['element_id' => $model->id]))) {
                $seo = ProductSeo::findOne(['element_id' => $model->id]);
            } else {
                $seo = new ProductSeo();
            }
        } elseif ($type == 'section') {
            $model = ProductSection::findOne(Yii::$app->request->get('id'));
            if (is_object(ProductSeo::findOne(['section_id' => $model->id]))) {
                $seo = ProductSeo::findOne(['section_id' => $model->id]);
            } else {
                $seo = new ProductSeo();
            }
        }

        //получение моделей всех свойств типа записи
        $propertyModel = new ProductProperty();
        $properties = $propertyModel->find()
            ->where(['implement' => $type, 'active' => 1])
            ->indexBy('id')
            ->all();

        $propertyIDs = [];
        $listPropertyIDs = [];
        foreach ($properties as $property) {
            if ($property['property_type'] == 'L') $listPropertyIDs[] = $property['id'];
            $propertyIDs[] = $property['id'];
        }

        // получение массива объектов значений свойств
        $valueModels = new ProductPropertyValue();
        $propValue = $valueModels->find()
            ->where(['property_id' => $propertyIDs, 'owner_id' => $model->id, 'own' => $typeOwn])
            ->indexBy('id')
            ->all();
        $result = [];
        foreach ($propValue as $val) {
            $result[$val->property_id][] = $val;
        }
        $propValue = $result;
        // dump($propValue, true);

        // получение массива всех значений вариантов списка
        $listEnumModels = new ProductPropertyEnum();
        $listEnums = $listEnumModels->find()
            ->where(['property_id' => $listPropertyIDs])
            ->all();
        $result = [];
        foreach ($listEnums as $Enum) {
            $result[$Enum['property_id']][] = $Enum;
        }
        $listEnums = $result;

        // формирование итогового массива с данными настроек свойства и его значениями
        $propData = [];
        foreach ($properties as $k => $property) {
            $propData[$k] = $property->getAttributes();
            $propData[$k]['value_model'] = $propValue[$k];
        }

        // получение новых пользовательских данных свойств и их описаний
        $postProperties = Yii::$app->request->post('properties');//dump($postProperties);die();
        $postDescriptions = Yii::$app->request->post('desc');
        if (count($postProperties) > 0) {//dump($_POST);die();
            //фомаирование массива с новыми даннми из POST
            $newData = [];
            foreach ($postProperties as $k => $postProp) {
                if (strpos($k, 'false_')) {
                    $k = str_replace('false_', '', $k);
                    $k = str_replace("'", '', $k);
                    $k = intval($k);
                    if (isset($newData[$k])) continue;
                }
                $newData[$k]['prop'] = $postProp;
                $newData[$k]['desc'] = $postDescriptions[$k];
            }
            // dump($newData);
            // dump($propData, true);

            //сохранение новых данныих
            foreach ($newData as $k => $data) {
                if ($propData[$k]['multiple'] > 0) {
                    foreach ($data['prop'] as $multi_k => $val) {
                        $this->savePropData($k, $model->id, $typeOwn, $val, $data['desc'][$multi_k], $propData[$k]['value_model'][$multi_k], $multi_k);
                    }
                } else {
                    $this->savePropData($k, $model->id, $typeOwn, $data['prop'], $data['desc'], $propData[$k]['value_model'][0]);
                }
            } // die();

            // получение сохраненных значений свойств
            $propValue = $valueModels->find()
                ->where(['property_id' => $propertyIDs, 'owner_id' => $model->id])
                ->all();
            $result = [];
            foreach ($propValue as $val) {
                $result[$val->property_id][$val->multi_id] = $val;
            }
            $propValue = $result;
        }

        // сохранение основных данных и SEO данных введенных пользователем
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($seo->load(Yii::$app->request->post()) && $seo->validate()) {
                if (strlen($seo->meta_title) > 0 || strlen($seo->meta_keywords) > 0 || strlen($seo->meta_description) > 0) {
                    $seo->save();
                }
                if (!Yii::$app->request->post('apply')) {
                    return $this->redirect(Url::previous());
                } else {
                    return $this->refresh();
                }
            }
        }

        //dump($detail); die();
        $images = new ImagesForm();
        if ($type == 'element') {
            // формирование данных картинок для вывода в форму редактирования
            if ($model->preview_picture > 0) {
                $src = FileHelper::getProductPath($model->preview_picture);
                $preview[] = '<img src="/shop' . $src . '" class="preview-thumb" />';
            } else {
                $preview[] = '';
            }
            if ($model->detail_picture > 0) {
                $src = FileHelper::getProductPath($model->detail_picture);
                $detail[] = '<img src="/shop' . $src . '" class="preview-thumb" />';
            } else {
                $detail[] = '';
            }

            $seo->element_id = $model->id;
            return $this->render('update-element', [
                'model' => $model,
                'images' => $images,
                'preview' => $preview,
                'detail' => $detail,
                'seo' => $seo,
                'properties' => $properties,
                'propValue' => $propValue,
                'listEnums' => $listEnums,
            ]);
        } elseif ($type == 'section') {
            if ($model->preview_image > 0) {
                $src = FileHelper::getProductPath($model->preview_image);
                $preview[] = '<img src="/shop' . $src . '" class="preview-thumb" />';
            } else {
                $preview[] = '';
            }
            $seo->section_id = $model->id;
            return $this->render('update', [
                'model' => $model,
                'images' => $images,
                'preview' => $preview,
                'seo' => $seo,
                'properties' =>$properties,
                'propValue' => $propValue,
                'listEnums' => $listEnums,
            ]);
        }
    }

    /**
     * Deletes an existing ProductSection model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeleteElement($id)
    {
        $query = ProductElement::find($id);
        $element = $query->where(['id'=>$id])->one();
        $element->delete();
        return $this->redirect(Url::previous());
    }

    /**
     * Finds the ProductSection model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductSection the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductSection::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемый товар не найден.');
        }
    }

    public function actionCreateProperty()
    {
        $model = new ProductProperty();
        $type = Html::encode(Yii::$app->request->get('type'));

        if($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            $this->redirect(Url::previous());
        }

        $model->implement = $type;
        $model->active = 1;
        $model->sort = 100;

        return $this->render('property-create', [
            'model'=> $model,
            'type' => $type,
        ]);
    }

    private function savePropData($property_id, $owner_id, $typeOwn, $value, $desc, $valueModel, $m_key=0 ) {
        //dump($valueModel, false, $property_id);
        if( is_object($valueModel) ) {
            if($value != '' || $desc != '') {
                $valueModel->value = $value;
                $valueModel->description = $desc;
                $valueModel->save();
            } else {
                $valueModel->delete();
            }
        } else {
            if($value == '' && $desc == '') return;
            $valueModel = new ProductPropertyValue();
            $valueModel->owner_id = $owner_id;
            $valueModel->own = $typeOwn;
            $valueModel->property_id = $property_id;
            $valueModel->multi_id = $m_key;
            $valueModel->value = $value;
            $valueModel->description = $desc;
            $valueModel->save();
        }
    }

    private function getPropertyListArray($type){
        $properties = ProductProperty::find()
            ->where(['implement' => $type, 'active' => 1])
            ->indexBy('id')
            ->all();

        return $properties;
    }

}
