<?php

namespace backend\controllers;

use Yii;
use common\models\cell\CellProperty;
use common\models\cell\CellPropertyEnum;
use common\models\cell\CellPropertySearch;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ContentPropertyController implements the CRUD actions for CellProperty model.
 */
class ContentPropertyController extends Controller
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
     * Lists all CellProperty models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CellPropertySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CellProperty model.
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
     * Creates a new CellProperty model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($cell_id, $type)
    {
        $model = new CellProperty();

        $propEnumModels = CellPropertyEnum::find()
            ->where(['property_id'=>$id])
            ->indexBy('name')
            ->all();

        if ($model->load(Yii::$app->request->post()) ) //dump($model, true);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            self::saveCellPropertyEnum($model);
            self::saveLinkPropertyEnum($model,$propEnumModels);

            if (!Yii::$app->request->post('apply')) {
                return $this->redirect(Url::previous('edit-cell'));
            } else {
                return $this->redirect(['update', 'id'=>$model->id]);
            }
        }

        $typeString = [
            'element' => 'элемента',
            'section' => 'раздела',
        ];
        $model->active = 1;
        $model->sort= 100;
        $model->own = $type;
        $model->cell_id = $cell_id;

        return $this->render('create', [
                'model' => $model,
                'type' => $typeString[$type],
            ]);
    }

    /**
     * Updates an existing CellProperty model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $propEnumModels = CellPropertyEnum::find()
            ->where(['property_id'=>$id])
            ->indexBy('name')
            ->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            self::saveCellPropertyEnum($model);
            self::saveLinkPropertyEnum($model, $propEnumModels);
            
            if (!Yii::$app->request->post('apply')) {
                return $this->redirect(Url::previous('edit-cell'));
            } else {
                return $this->redirect(['update', 'id'=>$model->id]);
            }
        }

        return $this->render('update', [
                'model' => $model,
                'propEnum' => $propEnumModels,
            ]);
    }

    /**
     * Deletes an existing CellProperty model.
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
     * Finds the CellProperty model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CellProperty the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CellProperty::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /*
     *
     */
    public function saveCellPropertyEnum($model) {
        $postPropEnum = Yii::$app->request->post('property-enum');
        if($postPropEnum[0]['code'] != '' && $model['property_type'] == 'L') {
            foreach($postPropEnum as $enum) {
                $enumRawModel = new CellPropertyEnum();
                if($enum['id'] > 0) {
                    $enumModel = $enumRawModel->findOne($enum['id']);
                } else {
                    $enumModel = $enumRawModel;
                }
                $enumModel->property_id = $model->id;
                $enumModel->code = $enum['code'];
                $enumModel->name = $enum['name'];
                $default = ($enum['by_default'] > 0) ? 1 : 0;
                $enumModel->by_default = $default;
                if($enumModel->code == '' || $enumModel->name == '') $result = $enumModel->delete();
                else {
                    $result = $enumModel->save();
                }
            }
        }

        return $result;
    }

    public function saveLinkPropertyEnum($model, $propEnumModels) {
        $postPropEnum = Yii::$app->request->post('link-property-setting');
        if($model['property_type'] == 'LS' || $model['property_type'] == 'LE') {
            foreach($postPropEnum as $k=>$val) {
                if(is_object($propEnumModels[$k])) {
                    $enumModel = $propEnumModels[$k];
                    $enumModel->name = $k;
                    $enumModel->code = $val;
                    if($val > 0) $result = $enumModel->save();
                        else $result = $enumModel->delete();
                    unset($propEnumModels[$k]);
                } elseif($val  > 0) {
                    $enumModel = new CellPropertyEnum();
                    $enumModel->property_id = $model->id;
                    $enumModel->name = $k;
                    $enumModel->code = $val;
                    $result = $enumModel->save();
                }
                if(count($propEnumModels) > 0) {
                    foreach($propEnumModels as $enumModel) {
                        $enumModel->delete();
                    }
                }
            }
            //dump($postPropEnum);
            //dump($propEnumModels);
        }

        return $result;
    }

}
