<?php

namespace backend\controllers;

use Yii;
use common\models\main\MainSettings;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MainController implements the CRUD actions for MainSettings model.
 */
class MainController extends Controller
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
     * Lists all MainSettings models.
     * @return mixed
     */
    public function actionSettings()
    {
        //dump(Yii::$app);
        $dataProvider = new ActiveDataProvider([
            'query' => MainSettings::find(),
        ]);

        return $this->render('settings', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MainSettings model.
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
     * Creates a new MainSettings model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionSettingCreate()
    {
        $model = new MainSettings();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (!Yii::$app->request->post('apply')) {
                return $this->redirect(['settings']);
            } else {
                return $this->redirect(['setting-update', 'id'=>$model->id]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MainSettings model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionSettingUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (!Yii::$app->request->post('apply')) {
                return $this->redirect(['settings']);
            } else {
                return $this->redirect(['setting-update', 'id'=>$model->id]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing MainSettings model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['settings']);
    }

    /**
     * Finds the MainSettings model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MainSettings the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MainSettings::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемый параметр не существует');
        }
    }

    /*
     *
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
