<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\Ehs;
use app\models\RegionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EhsController implements the CRUD actions for Ehs model.
 */
class EhsController extends MainController
{
  public function behaviors()
  {
    return [
      'access' => [
        'class' => AccessControl::className(),
        'rules' => [
          [
            'allow' => true,
            'actions' => ['index', 'view', 'create', 'update', 'delete'],
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
   * Lists all Ehs models.
   * @return mixed
   */
  public function actionIndex()
  {
    $dataProvider = new \yii\data\ActiveDataProvider([
      'query' => Ehs::find(),
    ]);

    if (isset(Yii::$app->request->queryParams['print'])) {
      return $this->printXls($dataProvider, 'EHS Assestment List');
    }

    $params = ['dataProvider' => $dataProvider,];
    if (Yii::$app->request->isAjax) {
      return $this->renderAjax('index', $params);
    }
    return $this->render('index', $params);
  }

  /**
   * Creates a new Ehs model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate()
  {
    $model = new Ehs();
    $isAjax = Yii::$app->request->isAjax;

    if ($model->load(Yii::$app->request->post())) {
      if ($model->save()) {
        $msg = "Create New Item \"$model->label\"";
        $this->log($msg);
        Yii::$app->cache->delete('ehs');
        if ($isAjax) {
          return $this->asJson(['success' => true, 'msg' => $msg]);
        }
        Yii::$app->session->setFlash('info', $msg);
        return $this->redirect(['index']);
      }
    }

    $params = [
      'title' => 'Create New Item',
      'model' => $model,
      'isAjax' => $isAjax,
      'redirect' => $this->httpRedirect
    ];
    if ($isAjax) {
      return $this->renderAjax('form', $params);
    }
    return $this->render('form', $params);
  }

  /**
   * Updates an existing Ehs model.
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
        $msg = "Update EHS \"$model->label\"";
        $this->log($msg);
        Yii::$app->cache->delete('ehs');
        if ($isAjax) {
          return $this->asJson(['success' => true, 'msg'=>$msg]);
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
   * Deletes an existing Ehs model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionDelete($id)
  {
    $model = $this->findModel($id);
    if($model->delete()){
      $msg = "Delete EHS \"$model->label\"";
      $this->log($msg);
      Yii::$app->cache->delete('ehs');
      if(Yii::$app->request->isAjax){
        return $this->asJson(['success' => true, 'msg'=>$msg]);
      }
      Yii::$app->session->setFlash('info', $msg);
      return $this->redirect(['index']);
    }
  }

  /**
   * Finds the Ehs model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return Ehs the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = Ehs::findOne($id)) !== null) {
      return $model;
    }
    throw new NotFoundHttpException('The requested data does not exist.');
  }
}
