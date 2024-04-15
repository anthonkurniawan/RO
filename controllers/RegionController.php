<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\Region;
use app\models\RegionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RegionController implements the CRUD actions for Region model.
 */
class RegionController extends MainController
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
   * Lists all Dept models.
   * @return mixed
   */
  public function actionIndex()
  {
    \yii\helpers\Url::remember();
    $param = Yii::$app->request->queryParams;
    $searchModel = new RegionSearch();
    $dataProvider = $searchModel->search($param);

    if (isset(Yii::$app->request->queryParams['print'])) {
      return $this->printXls($dataProvider, 'Regional List');
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
   * Creates a new region model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate()
  {
    $model = new Region();
    $isAjax = Yii::$app->request->isAjax;

    if ($model->load(Yii::$app->request->post())) {
			$q="SET IDENTITY_INSERT region ON; insert into region(id, dept_id, nama) VALUES ((select max(id)+1 from region), 1, :name)";
			// $mysql="insert into region(id, dept_id, nama) VALUES ((select max(id)+1 from region), 1, :name)";
			if($model->validate()){
				$rs = \Yii::$app->db->createCommand($q)->bindValue(':name', $model->nama)->execute();
				if($rs) {
					$msg = "Create New Region \"$model->nama\"";
					$this->log($msg);
					Yii::$app->cache->delete('region');
					if ($isAjax) {
						return $this->asJson(['success' => true, 'msg'=>$msg]);
					}
					Yii::$app->session->setFlash('info', $msg);
					return $this->redirect(['index']);
				}
			}
    }

    $params = [
      'title'=>'Create Region',
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
        $msg = "Update Region \"$model->nama\"";
        $this->log($msg);
        Yii::$app->cache->delete('region');
        if ($isAjax) {
          return $this->asJson(['success' => true, 'msg'=>$msg]);
        }
        Yii::$app->session->setFlash('info', $msg);
        return $this->redirect(['index']);
      }
    }

    $params = [
      'title'=>"Update \"$model->nama\"",
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
   * Deletes an existing Region model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionDelete($id)
  {
    $model = $this->findModel($id);
    if($model->delete()){
      $msg = "Delete Region \"$model->nama\"";
      $this->log($msg);
      Yii::$app->cache->delete('region');
      if(Yii::$app->request->isAjax){
        return $this->asJson(['success' => true, 'msg'=>$msg]);
      }
      Yii::$app->session->setFlash('info', $msg);
      return $this->redirect(['index']);
    }
  }

    /**
     * Finds the Region model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Region the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
  protected function findModel($id)
  {
    if (($model = Region::findOne($id)) !== null) {
      return $model;
    }
    throw new NotFoundHttpException('The requested data does not exist.');
  }
}
