<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\Dept;
use app\models\DeptSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DeptController implements the CRUD actions for Dept model.
 */
class DepartementController extends MainController
{
  /**
   * {@inheritdoc}
   */
  public function behaviors()
  {
    return [
      'access' => [
        'class' => AccessControl::className(),
        'rules' => [
          [
            'allow' => true,
            'actions' => ['index', 'view', 'create', 'update', 'delete', 'test'],
            'matchCallback' => function ($rule, $action) {
              return Yii::$app->user->identity && Yii::$app->user->identity->isAdmin;
            }
          ],
        ],
      ],
      'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
          'delete' => ['POST'],
        ],
      ],
    ];
  }

  /**
   * Lists all Dept models.
   * @return mixed
   */
  public function actionIndex()
  {
    \yii\helpers\Url::remember();
    $param = Yii::$app->request->queryParams;
    $searchModel = new DeptSearch();
    $dataProvider = $searchModel->search($param);

    if (isset(Yii::$app->request->queryParams['print'])) {
      return $this->printXls($dataProvider, 'Departement List');
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
   * Creates a new Dept model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate()
  {
    $model = new Dept();
    $isAjax = Yii::$app->request->isAjax;

    if ($model->load(Yii::$app->request->post())) {
      //$this->performAjaxValidation($model);
      if($model->save()) {
        $msg = "Create New Departement \"$model->label\"";
        Yii::$app->cache->delete('dept');
        $this->log($msg);
        if ($isAjax) {
          return $this->asJson(['success' => true,'msg'=>$msg]);
        }
        Yii::$app->session->setFlash('info', $msg);
        return $this->redirect(['index']);
      }
    }

    $params = [
      'title'=>'Create Departement',
      'model' => $model,
      'isAjax' => $isAjax,
      'redirect' => $this->httpRedirect
    ];
    if($isAjax){
      return $this->renderAjax('form', $params);
    }
    return $this->render('form', $params);
  }

  /**
   * Updates an existing Dept model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionUpdate($id)
  {
    $model = $this->findModel($id);
    $isAjax = Yii::$app->request->isAjax;

    if ($model->load(Yii::$app->request->post())) {
      if($model->save()){
        $msg = "Update Departement \"$model->label\"";
        Yii::$app->cache->delete('dept');
        $this->log($msg);
        if ($isAjax) {
          return $this->asJson(['success' => true,'msg'=>$msg]);
        }
        Yii::$app->session->setFlash('info', $msg);
        return $this->redirect(['index']);
      }
    }

    $params = [
      'title'=>"Update \"$model->label\"",
      'model' => $model,
      'isAjax' => $isAjax,
      'redirect' => $this->httpRedirect
    ];
    if($isAjax){
      return $this->renderAjax('form', $params);
    }
    return $this->render('form', $params);
  }

  /**
   * Deletes an existing Dept model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionDelete($id)
  {
    $model = $this->findModel($id);
    if($model->delete()){
      $msg = "Delete Departement \"$model->label\"";
      $this->log($msg);
      Yii::$app->cache->delete('dept');
      if(Yii::$app->request->isAjax){
        return $this->asJson(['success' => true, 'msg'=>$msg]);
      }
      Yii::$app->session->setFlash('info', $msg);
      return $this->redirect(['index']);
    }
  }

  /**
   * Finds the Dept model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return Dept the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = Dept::findOne($id)) !== null) {
      return $model;
    }
    throw new NotFoundHttpException('The requested data does not exist.');
  }

}
