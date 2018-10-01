<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 17.12.2017
 * Time: 17:40
 */

namespace backend\controllers;

use Yii;
use common\models\components\ComponentList;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class TemplatesController extends Controller
{
    //public $templateDir = Yii::getAlias('@app/frontend/cms-data/templates');
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
     * Lists all ComponentList models.
     * @return mixed
     */
    public function actionIndex()
    {
        $templates = $this->getTemplateList();

        return $this->render('index', [
            'templates' => $templates,
        ]);
    }

    /**
     * Displays a single ComponentList model.
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
     * Creates a new ComponentList model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ComponentList();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ComponentList model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            //if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $params = Yii::$app->request->post('params');
            if($params["code"][0] != '') {
                $model->params = ComponentList::createParamsString($params);
                $model->save();
            }
            return $this->redirect(['index']);
        } else {
            $model->makeParamsArray();
            //dump($model);
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ComponentList model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    private function getTemplateList() {
        $tempDir = Yii::getAlias(Yii::$app->params['templatesPath']);
        $d = opendir($tempDir);
        $templates = [];
        while(($e = readdir($d)) !== false) {
            if(strpos($e, '.') !== false) continue;
            $templates[$e] = ['code' => $e];
        }
        foreach($templates as $dirName=>&$params) {
            $newParams = include($tempDir . $dirName . '/parameters.php');
            $params = array_merge($params, $newParams);
        }
        return $templates;
    }
}