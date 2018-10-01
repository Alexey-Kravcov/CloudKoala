<?php

namespace backend\controllers;

use common\models\menu\MenuGroup;
use common\models\menu\MenuGroupSearch;
use common\models\menu\MenuAssign;
use Yii;
use common\models\menu\MenuItem;
use common\models\menu\MenuItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MenusController implements the CRUD actions for MenuItem model.
 */
class MenusController extends Controller
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
     * Lists all MenuItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new MenuGroup();
        $menuModels = $model->getMenuItems();
        $menuItems = MenuItem::find()->indexBy('id')->all();
        // dump($_POST, true);
        if (Yii::$app->request->post('menu')) {
            $i = 1;
            $arrIds = [];
            // dump(Yii::$app->request->post('menu'));
            // созранение присланных данных
            foreach(Yii::$app->request->post('menu') as $item) {

                $menu_id = $item['menu_id'];
                $itemModel = MenuAssign::find()
                    ->where(['menu_item'=>$item['item_id'], 'menu_group'=>$item['menu_id']])
                    ->one();
                if(is_object($itemModel)) {
                    //dump($item);
                    $itemModel->menu_group = $item['menu_id'];
                    $itemModel->menu_item= $item['item_id'];
                    $itemModel->position= $i;
                    $itemModel->save();
                    $arrIds[] = $itemModel->id;
                    // dump($itemModel);
                } else {
                    $itemModel = new MenuAssign();
                    $itemModel->menu_group = $item['menu_id'];
                    $itemModel->menu_item= $item['item_id'];
                    $itemModel->position= $i;
                    $itemModel->save();
                    $arrIds[] = $itemModel->id;
                }
                $i++;
            }
            // удаление теперь несуществующих пуктов меню
            $allMenuItem = MenuAssign::find()
                ->where(['menu_group'=>$menu_id])
                ->indexBy('id')
                ->all();
            $modelKeys = array_keys($allMenuItem);
            foreach($modelKeys as $modelId) {
                if(in_array($modelId, $arrIds)) continue;
                else {
                    //dump($allMenuItem[$modelId]);
                    $allMenuItem[$modelId]->delete();
                }
            }

            // dump($_POST, true);
            if (!Yii::$app->request->post('apply')) {
                return $this->redirect(['index']);
            } else {
                return $this->refresh();
            }
        }

        return $this->render('index', [
            'menuModels' => $menuModels,
            'menuItems' => $menuItems,
        ]);
    }
    public function actionListMenuItem()
    {
        $searchModel = new MenuItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index-item', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MenuItem model.
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
     * Creates a new MenuItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateItem()
    {
        $model = new MenuItem();

        $items = MenuItem::find()
            ->all();
        //dump($items);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (!Yii::$app->request->post('apply')) {
                return $this->redirect(['index']);
            } else {
                return $this->refresh();
            }
        }

        $model->sort = 100;
        return $this->render('create_item', [
            'model' => $model,
            'items' => $items,
        ]);

    }

    /**
     * Updates an existing MenuItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdateGroup($id)
    {
        $model = $this->findGroupModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if(!Yii::$app->request->post('apply')) {
                return $this->redirect(['index']);
            } else {
                return $this->refresh();
            }
        }

        return $this->render('update-group', [
            'model' => $model,
            'items' => $items,
        ]);
    }

    public function actionUpdateItem($id)
    {
        $model = $this->findItemModel($id);
        $items = MenuItem::find()
            ->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if(!Yii::$app->request->post('apply')) {
                return $this->redirect(['list-menu-item']);
            } else {
                return $this->refresh();
            }
        }

        return $this->render('update-item', [
                'model' => $model,
                'items' => $items,
        ]);
    }

    /**
     * Deletes an existing MenuItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    public function actionCreateMenu() {
        $model = new MenuGroup();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        $model->sort = 100;
        return $this->render('create-menu', [
            'model' => $model,
        ]);

    }

    /**
     * Finds the MenuItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MenuItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findItemModel($id)
    {
        if (($model = MenuItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемый пункт не существует');
        }
    }

    protected function findGroupModel($id)
    {
        if (($model = MenuGroup::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемое меню не существует');
        }
    }
}
