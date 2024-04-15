<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\Tag;
use app\models\TagSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
// use Exception;

/**
 * TagController implements the CRUD actions for Tag model.
 */
class TagController extends MainController
{
  /**
   * {@inheritdoc}
   */
  public function behaviors()
  {
    return [
      'access'=>[
        'class'=>AccessControl::className(),
        'rules'=>[
          [
            'allow'=>true,
            'actions'=>['index', 'view', 'create', 'update', 'delete', 'print', 'area-suggest'],
            'matchCallback' => function ($rule, $action) {
              return Yii::$app->user->identity && Yii::$app->user->identity->isAdmin;
            }
          ],
        ],
      ],
      'verbs'=>[
        'class'=>VerbFilter::className(),
        'actions'=>[
          'delete'=>['POST'],
        ],
      ],
    ];
  }

  /**
   * Lists all Tag models.
   * @return mixed
   */
  public function actionIndex()
  {
    \yii\helpers\Url::remember();
    $param = Yii::$app->request->queryParams;
    $searchModel = new TagSearch();
    $dataProvider = $searchModel->search($param);

    if (isset(Yii::$app->request->queryParams['print'])) {
      return $this->printXls($dataProvider, 'Tag Number List');
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
   * Creates a new Tag model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate()
  {
    $model = new Tag();
    $isAjax = Yii::$app->request->isAjax;

    if ($model->load(Yii::$app->request->post())) {
      if($model->save()) {
        $msg = "Create New Tag-Number \"$model->tagnum\"";
        $this->log($msg);
				Yii::$app->cache->delete('tags');
        if ($isAjax) {
          return $this->asJson(['success' => true, 'msg'=>$msg]);
        }
        Yii::$app->session->setFlash('info', $msg);
        return $this->redirect(['index']);
      }
    }

    $params = [
      'title'=>'Create New Tag-Number',
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
   * Updates an existing Tag model.
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
        $msg = "Update Tag-number \"$model->tagnum\"";
        $this->log($msg);
				Yii::$app->cache->delete('tags');
        if ($isAjax) {
          return $this->asJson(['success' => true,'msg'=>$msg]);
        }
        Yii::$app->session->setFlash('info', $msg);
        return $this->redirect(['index']);
      }
    }

    $params = [
      'title'=>"Update \"$model->tagnum\"",
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
   * Deletes an existing Tag model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionDelete($id)
  {
    $model = $this->findModel($id, 1);
    if($model->delete()){
      $msg = "Delete tag-number \"$model->tagnum\"";
      $this->log($msg);
			Yii::$app->cache->delete('tags');
      if(Yii::$app->request->isAjax){
        return $this->asJson(['success' => true, 'msg'=>$msg]);
      }
      Yii::$app->session->setFlash('info', $msg);
      return $this->redirect(['index']);
    }
  }

  /**
   * Finds the Tag model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return Tag the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id, $isDelete=false)
  {
    if($isDelete){
      $tag = Tag::findOne($id);
    }else{
      $tag = Tag::find()
      ->select(['tag.*', 'area.label_a as area_name'])
      ->where('tag.id=:id')->addParams([':id'=>$id])
      ->join('LEFT JOIN', 'area', 'tag.area_id = area.id')->one();
    }

    if ($tag !== null) {
      return $tag;
    }
    throw new NotFoundHttpException('The requested data does not exist.');
  }
}
