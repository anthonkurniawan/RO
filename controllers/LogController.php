<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\Log;
use app\models\LogSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LogController implements the CRUD actions for Log model.
 */
class LogController extends MainController
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
            'actions' => ['index', 'view', 'create', 'update', 'delete', 'print'],
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
   * Lists all Log models.
   * @return mixed
   */
  public function actionIndex()
  {
    \yii\helpers\Url::remember();
    $param = Yii::$app->request->queryParams;
    $searchModel = new LogSearch();
    $dataProvider = $searchModel->search($param);

    if (isset(Yii::$app->request->queryParams['print'])) {
      return $this->printXls($dataProvider, 'Audit Trail');
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
   * Deletes an existing Log model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionDelete($id)
  {
    $model = $this->findModel($id);
    if($model->delete()){
      $msg = "Delete log \"$model->id\"";
      $this->log($msg);
      if(Yii::$app->request->isAjax){
        return $this->asJson(['success' => true, 'msg'=>$msg]);
      }
      Yii::$app->session->setFlash('info', $msg);
      return $this->redirect(['index']);
    }
  }


  /**
   * Finds the Log model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return Log the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = Log::findOne($id)) !== null) {
      return $model;
    }
    throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
  }
}
