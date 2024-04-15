<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\User;
use app\models\UserSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends MainController
{
  /**
   * {@inheritdoc}
   */
  public function behaviors() {
    return [
      'access' => [
        'class' => AccessControl::className(),
        //'only' => ['index', 'view', 'create'],
        'rules' => [
          [
            'allow' => true,
            'actions' => ['index', 'view', 'create', 'update', 'delete', 'activate', 'disable', 'reset-password', 'print'],
            'matchCallback' => function ($rule, $action) {
              return Yii::$app->user->identity && Yii::$app->user->identity->isAdmin;
             }
          ],
        ],
        // 'denyCallback' => function ($rule, $action) {
        //   throw new \Exception('You are not allowed to access this page BRO!');
        // }
      ],
      'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
					'activate' => ['POST'],
					'disable' => ['POST'],
					'delete' => ['POST']
        ],
      ],
    ];
  }

  /**
   * Lists all User models.
   * @return mixed
   */
  public function actionIndex()
  {
    \yii\helpers\Url::remember();
    $param = Yii::$app->request->queryParams;
    $searchModel = new UserSearch();
    $dataProvider = $searchModel->search($param);

    if (isset(Yii::$app->request->queryParams['print'])) {
      return $this->printXls($dataProvider, 'User List');
    }

    $params = [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
    ];
    if(Yii::$app->request->isAjax){
      return $this->renderAjax('index', $params);
    }
    return $this->render('index', $params);
  }

  /**
   * Creates a new User model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate()
  {
    $model = new User(['scenario' => 'create']);
    $isAjax = Yii::$app->request->isAjax;

    if ($model->load(Yii::$app->request->post())) {
			$model->setPassword('1234');

      if($model->save()) {
        $msg = "Create New User \"$model->uname\"";
        $this->log($msg);
        Yii::$app->cache->delete('user');
        if ($isAjax) {
          return $this->asJson(['success' => true, 'msg'=>$msg]);
        }
        Yii::$app->session->setFlash('info', $msg);
        return $this->redirect(['index']);
      }
			// $this->performAjaxValidation($model);
    }

    $params = [
      'title'=>'Create User',
      'model' => $model,
      'isAjax' => $isAjax,
      'redirect' => $this->httpRedirect,
			'ldap_enable' => \Yii::$app->params['ldap_enable']
    ];
    if($isAjax){
      return $this->renderAjax('form', $params);
    }
    return $this->render('form', $params);
  }

  /**
   * Updates an existing User model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionUpdate($id)
  {
    $model = $this->findModel($id);
    $model->scenario = 'update';
    $isAjax = Yii::$app->request->isAjax;

    if ($model->load(Yii::$app->request->post())) {
			// \yii\helpers\VarDumper::dump($model->attributes, 10, true); die();
      if($model->save()){
        $msg = "Update User \"$model->uname\"";
        $this->log($msg);
        Yii::$app->cache->delete('user');
        Yii::$app->cache->delete('user-'.$id);
        if ($isAjax) {
          return $this->asJson(['success' => true, 'msg'=>$msg]);
        }
        // Yii::$app->session->setFlash('info', $msg);
        // return $this->redirect(['user/index']);
      }
    }

    $params = [
      'title'=>"Update User #$model->id",
      'model' => $model,
      'isAjax' => $isAjax,
      'redirect' => $this->httpRedirect,
			'ldap_enable' => \Yii::$app->params['ldap_enable']
    ];
    if($isAjax){
      return $this->renderAjax('form', $params);
    }
    return $this->render('form', $params);
  }

  # Reset Password by token: ActionReset -> ResetModel -> getUserByResetToken -> userModel -> resetPassword(user->pass)
  # Reset Password expired  ActionReset -> ResetModel -> UserModel->save()
  public function actionResetPassword($id){ 
    $model = $this->findModel($id);
    $model->scenario = 'reset-password';
    $isAjax = Yii::$app->request->isAjax;

    if ($model->load(Yii::$app->request->post())) {
      if($model->save()){
        $msg = "Update password User \"$model->uname\"";
        $this->log($msg);
        Yii::$app->cache->delete('user-'.$id);
        if ($isAjax) {
          return $this->asJson(['success' => true, 'msg'=>$msg]);
        }
        Yii::$app->session->setFlash('info', $msg);
        return $this->redirect(['index']);
      }
    }

    $params = [
      'title'=>"Update password  #$model->id",
      'model' => $model,
      'isAjax' => $isAjax,
      'redirect' => $this->httpRedirect
    ];
    if($isAjax){
      return $this->renderAjax('reset-password', $params);
    }
    return $this->render('reset-password', $params);
  }

  /**
   * Deletes an existing User model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionDelete($id)
  {
    $model = $this->findModel($id, 1);
    if($model->delete()){
      $msg = "Delete user \"$model->uname\"";
      $this->log($msg);
      Yii::$app->cache->delete('user');
      Yii::$app->cache->delete('user-'.$id);
      if(Yii::$app->request->isAjax){
        return $this->asJson(['success' => true, 'msg'=>$msg]);
      }
      Yii::$app->session->setFlash('info', $msg);
      return $this->redirect(['index']);
    }
  }
	
	public function actionActivate($id)
  {
		$rs = \Yii::$app->db->createCommand("Update users set status=1, blocked_at=NULL WHERE id=:id")->bindValue(':id', $id)->execute();
		if($rs){
			Yii::$app->cache->delete('user');
      Yii::$app->cache->delete('user-'.$id);
			$msg = "Activate user \"$id\"";
      $this->log($msg);
			if(Yii::$app->request->isAjax){
        return $this->asJson(['success' => true, 'msg'=>$msg]);
      }
      Yii::$app->session->setFlash('info', $msg);
		}
		return $this->redirect(['index']);
  }
	
	public function actionDisable($id)
  {
		$rs = \Yii::$app->db->createCommand("Update users set status=0, blocked_at=".time()." WHERE id=:id")->bindValue(':id', $id)->execute();
		if($rs){
			Yii::$app->cache->delete('user');
      Yii::$app->cache->delete('user-'.$id);
			$msg = "Disable user \"$id\"";
      $this->log($msg);
			if(Yii::$app->request->isAjax){
        return $this->asJson(['success' => true, 'msg'=>$msg]);
      }
      Yii::$app->session->setFlash('info', $msg);
		}
		return $this->redirect(['index']);
  }
	
  /**
   * Finds the User model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return User the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id, $isDelete=false)
  {
    if($isDelete){
      $user = User::findOne($id);
    }else{
      $user = User::findUser($id);
    }

    if ($user !== null) {
      return $user;
    }
    throw new NotFoundHttpException('The requested data does not exist.');
  }
}
