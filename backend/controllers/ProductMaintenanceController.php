<?php

namespace backend\controllers;

use common\models\product\ProductPropertyEnum;
use Yii;
use common\models\product\ProductProperty;
use common\models\product\ProductPropertySearchModel;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductMaintenanceController implements the CRUD actions for ProductProperty model.
 */
class ProductMaintenanceController extends Controller
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
     * Lists all ProductProperty models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductPropertySearchModel();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductProperty model.
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
     * Creates a new ProductProperty model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProductProperty();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (!Yii::$app->request->post('apply')) {
                return $this->redirect(Url::previous());
            } else {
                return $this->redirect(['update', 'id'=>$model->id]);
            }
        }
        $model->sort = 100;
        $model->active = 1;
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ProductProperty model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $searchModel = new ProductPropertySearchModel();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $propEnumModel = new ProductPropertyEnum();
        $propEnum = $propEnumModel->find()
            ->where(['property_id' => $id])
            ->all();
        if(count($propEnum) < 1) $propEnum = $propEnumModel;

        $postPropEnum = Yii::$app->request->post('property-enum');
        if($postPropEnum[0]['code'] != '' && $_POST['ProductProperty']['property_type'] == 'L') {
            $saveFlag = false;
            foreach($postPropEnum as $enum) {
                $enumRawModel = new ProductPropertyEnum();
                if($enum['id'] > 0) {
                    $enumModel = $enumRawModel->find()->where(['id' => $enum['id']])->one();
                } else {
                    $enumModel = $enumRawModel;
                }
                $enumModel->property_id = $id;
                $enumModel->code = $enum['code'];
                $enumModel->name = $enum['name'];
                $default = ($enum['by_default'] > 0) ? 1 : 0;
                $enumModel->by_default = $default;
                //dump($enumModel);
                if($enumModel->code == '' || $enumModel->name == '') $enumModel->delete();
                    else {
                        $enumModel->save();
                        $saveFlag = true;
                    }
            }
            $propEnum = $propEnumModel->find()
                ->where(['property_id' => $id])
                ->all();
        }
        //dump($propEnum);
        //die();


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if(Yii::$app->request->post('apply') == 0) return $this->redirect(['index', [
                                                                    'searchModel' => $searchModel,
                                                                    'dataProvider' => $dataProvider,
                                                                ]]);
        }
        return $this->render('update', [
            'model' => $model,
            'propEnum' => $propEnum,
        ]);

    }

    /**
     * Deletes an existing ProductProperty model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProductProperty model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductProperty the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductProperty::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
