<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\OrderType;;
use app\models\RegionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PriorityController implements the CRUD actions for OrderType model.
 */
class OrderTypeController extends MainController
{
  public function behaviors()
  {
    return [
      'access' => [
        'class' => AccessControl::className(),
        'rules' => [
          [
            'allow' => true,
            'actions' => ['index', 'create', 'update', 'delete'],
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
   * Lists all OrderType models.
   * @return mixed
   */
  public function actionIndex()
  {
    \yii\helpers\Url::remember();
    $dataProvider = new \yii\data\ActiveDataProvider([
      'query' => OrderType::find(),
    ]);

    if (isset(Yii::$app->request->queryParams['print'])) {
      return $this->printXls($dataProvider, 'OrderType List');
    }

    $params = ['dataProvider' => $dataProvider,];
    if (Yii::$app->request->isAjax) {
      return $this->renderAjax('index', $params);
    }
    return $this->render('index', $params);
  }

  /**
   * Creates a new OrderType model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate()
  {
    $model = new OrderType();
    $isAjax = Yii::$app->request->isAjax;

    if ($model->load(Yii::$app->request->post())) {
      if ($model->save()) {
        $msg = "Create New Type \"$model->label\"";
        $this->log($msg);
        Yii::$app->cache->delete('order_type');
        if ($isAjax) {
          return $this->asJson(['success' => true, 'msg' => $msg]);
        }
        Yii::$app->session->setFlash('info', $msg);
        return $this->redirect(['index']);
      }
    }

    $params = [
      'title' => 'Create Request Type',
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
   * Updates an existing OrderType model.
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
        $msg = "Update Request Type \"$model->label\"";
        $this->log($msg);
        Yii::$app->cache->delete('order_type');
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
   * Deletes an existing OrderType model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionDelete($id)
  {
    $model = $this->findModel($id);
    if($model->delete()){
      $msg = "Delete Request Type \"$model->label\"";
      $this->log($msg);
      Yii::$app->cache->delete('order_type');
      if(Yii::$app->request->isAjax){
        return $this->asJson(['success' => true, 'msg'=>$msg]);
      }
      Yii::$app->session->setFlash('info', $msg);
      return $this->redirect(['index']);
    }
  }

  /**
   * Finds the OrderType model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return OrderType the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = OrderType::findOne($id)) !== null) {
      return $model;
    }
    throw new NotFoundHttpException('The requested data does not exist.');
  }
}
