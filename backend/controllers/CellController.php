<?php

namespace backend\controllers;

use Yii;
use common\models\cell\CellType;
use common\models\cell\CellTypeSearch;
use common\models\cell\CellItem;
use common\models\cell\CellItemSearch;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CellController implements the CRUD actions for CellType model.
 */
class CellController extends Controller
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
     * Lists all CellType models.
     * @return mixed
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
            'template' => 'type',
        ]);
    }

    public function actionIndexType($id)
    {
        $searchModel = new CellItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $cellTypeModels = CellType::find()
            ->orderBy('sort')
            ->all();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'cellTypeModels' => $cellTypeModels,
            'template' => 'item',
            'type_id' => $id,
        ]);
    }

    /**
     * Displays a single CellType model.
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
     * Creates a new CellType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateType()
    {
        $model = new CellType();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (!Yii::$app->request->post('apply')) {
                return $this->redirect(['index']);
            } else {
                return $this->redirect(['update-type', 'id'=>$model->id]);
            }
        }
        $model->sort = 100;
        return $this->render('create-type', [
            'model' => $model,
        ]);
    }
    public function actionCreateItem()
    {
        $model = new CellItem();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (!Yii::$app->request->post('apply')) {
                return $this->redirect(['index-type', 'id'=>$model->cell_type_id]);
            } else {
                return $this->redirect(['update-item', 'id'=>$model->cell_type_id]);
            }
        }
        $typeCellID = Yii::$app->request->get('type_id');
        $typeModel = CellType::findOne($typeCellID);

        $model->sort = 100;
        $model->active = 1;
        $model->searchable = 1;
        return $this->render('create-item', [
            'model' => $model,
            'typeModel' => $typeModel,
        ]);
    }

    /**
     * Updates an existing CellType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdateType($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (!Yii::$app->request->post('apply')) {
                return $this->redirect(['index']);
            } else {
                return $this->refresh();
            }
        }
        return $this->render('update_type', [
            'model' => $model,
        ]);
    }
    public function actionUpdateItem($id)
    {
        $model = $this->findItemModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (!Yii::$app->request->post('apply')) {
                //return $this->redirect(['index-type', 'id'=>$model->cell_type_id]);
                return $this->redirect(['index-type', 'id'=>$model->cell_type_id]);
            } else {
                return $this->redirect(['update-item', 'id'=>$model->cell_type_id]);
            }
        }
        return $this->render('update-item', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CellType model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    public function actionDeleteItem($id)
    {
        $this->findItemModel($id)->delete();

        return $this->redirect(Url::previous());
    }

    /**
     * Finds the CellType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CellType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CellType::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемый тип не существует');
        }
    }

    protected function findItemModel($id)
    {
        if (($model = CellItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемая ячейка не существует');
        }
    }
}
