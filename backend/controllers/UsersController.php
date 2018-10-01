<?php

namespace backend\controllers;

use Yii;
use common\models\users\User;
use common\models\users\Profile;
use common\models\users\ProfileSearch;
use yii\behaviors\TimestampBehavior;
use yii\db\Query;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsersController implements the CRUD actions for Profile model.
 */
class UsersController extends Controller
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
     * Lists all Profile models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProfileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Profile model.
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
     * Creates a new Profile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Profile();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Profile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);


        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            return $this->redirect(['index']);
        } else {
            //echo "<pre>";print_r($model); echo "</pre>";
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdateLogin($id) {
        if($model = User::findOne($id) !== null) {

            //dump($model);
            return $this->render('update-login', [
                'model' => $model,
            ]);
        } else {
            throw new NotFoundHttpException('Такой пользователь не существует.');
        }
    }

    /**
     * Deletes an existing Profile model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionRoles() {

        if(Yii::$app->request->isPost && Yii::$app->request->isAjax){
            $role = Yii::$app->request->post('role');
            $username = Yii::$app->request->post('username');
            $modelRole = Yii::$app->authManager->getRole($role);
            $rbac = Yii::$app->authManager;
            $rbac->revokeAll($username);
            $rbac->assign($modelRole, $username);
            // echo "<pre>";print_r($modelRole);echo"</pre>";
            return $this->redirect(['users/roles']);
        }

        $query = new Query();
        $roles = $query->from('auth_item')
                    ->where(['type'=> 1])
                    ->indexBy('name')
                    ->all();
        $query = new Query();
        $users = $query->from('user')
            ->join('LEFT JOIN', 'auth_assignment', 'auth_assignment.user_id = user.id')
            ->all();

        return $this->render('roles', [
            'roles'=>$roles,
            'users'=>$users,
        ]);
    }

    public function actionPermissions() {

        if(Yii::$app->request->isPost && Yii::$app->request->isAjax) {
            $role = Yii::$app->request->post('role');
            $perm = Yii::$app->request->post('perm');
            $set = Yii::$app->request->post('set');
            $rbac = Yii::$app->authManager;
            $roleModel = $rbac->getRole($role);
            $permModel = $rbac->getPermission($perm);
            // dump($roleModel);
            //return;
            if ($set > 0) {
                if($rbac->addChild($roleModel, $permModel )) echo "<p class='green'> Обновлено</p>";
                else echo "<p class='red'>Ошибка при обновлении данных</p>";
            } else {
                if($rbac->removeChild($roleModel, $permModel)) echo "<p class='green'> Обновлено</p>";
                    else echo "<p class='red'>Ошибка при обновлении данных</p>";
            }
            //$this->redirect(['users/permissions']);

            return false;
        } else {
            $rbac = Yii::$app->authManager;
            $roles = $rbac->getRoles();
            $listPermissions = $rbac->getPermissions();
            $permissions = [];
            foreach ($roles as $key => $role) {
                $permissions[$key] = Yii::$app->authManager->getPermissionsByRole($key);
            }
            //dump($permissions);

            return $this->render('permissions', [
                'permissions' => $permissions,
                'list' => $listPermissions,
            ]);
        }
    }

    /**
     * Finds the Profile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Profile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Profile::findOne($id)) !== null) {
            // dump($model);
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}
