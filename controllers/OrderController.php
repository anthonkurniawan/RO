<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\Order;
use app\models\OrderSearch;;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Exception;

use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * OrderController implements the CRUD actions for Orders model.
 */
class OrderController extends MainController
{
  /**
   * {@inheritdoc}
   */
  public function behaviors()
  {
    return [
      'access'=>[
        'class'=>AccessControl::className(),
        //'only'=>['index', 'view', 'create'],
        'rules'=>[
          [
            'allow'=>true,
            'actions'=>['index','view','create','update','delete','suggest','tag-suggest','user-suggest','area-suggest','print','get-type-legend','print1'],
            'roles'=>['@'],
            // 'matchCallback'=>function ($rule, $action) {
            //   return Yii::$app->user->identity && Yii::$app->user->identity->isAdmin;
            // }
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
   * Lists all Orders models.
   * @return mixed
   */
  public function actionIndex()
  {
		$req = Yii::$app->request;
    $param = $req->queryParams;
    $searchModel = new OrderSearch();
    $dataProvider = $searchModel->search($param);
    \yii\helpers\Url::remember();

    if(isset($param['print'])) {
      return $this->printXls($dataProvider, 'Report Request Order');
    }

    $params = [
      'searchModel'=>$searchModel,
      'dataProvider'=>$dataProvider,
    ];
    if($req->isAjax){
      return $this->renderAjax('index', $params);
    }
    return $this->render('index', $params);
  }

  /**
   * Creates a new Orders model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate($region=null)
  {
    \yii\helpers\Url::remember();
		$req = Yii::$app->request;
    $isAjax = $req->isAjax;

    if(!$region){
      if($isAjax){
        return $this->renderAjax('create', ['isAjax'=>$isAjax, 'redirect'=>$this->httpRedirect]);
      }
      return $this->render('create', ['isAjax'=>$isAjax, 'redirect'=>$this->httpRedirect]);
    }

    $model = new Order();
    $model->scenario = "create";
    $model->region_id = $region;
    $model->getId();  // format region-id + month + year + index count
    $user = Yii::$app->user->identity;

		$model->initiator_name = $user->fullname;
    $model->initiator_dept = $user->dept_name;
    $model->initiator_id = $user->id;
    $model->dept_id = $user->dept_id;
		$model->ehs_assest = 1;
		$model->ehs_hazard = 1;
		
    if($model->load($post = $req->post())) {
      $model->status = $model::STATUS_OPEN;
      $model->create_at = date('Y-m-d H:i:s');
			if($model->target_dt)
				$model->target_dt = date('Y-m-d', strtotime($model->target_dt));
			$model->assignTo_email = $post['Order']['assignTo_email'];
			$model->assignTo_fullname = $post['Order']['assignTo_fullname'] ? $post['Order']['assignTo_fullname'] : $post['Order']['assignTo_name'];
			if($model->quality_ass==1){
				$model->mmnr='';
			}
			if($model->ehs_assest==1){
				$model->ehs_hazard = 1;
				$model->ehs_hazard_risk='';
			}

			$ses = Yii::$app->session;
      if($model->save()){
        $this->log("Create order $model->id");
        $msg = "Order $model->id has been submitted";
				$mail = $this->sendMail($model, $model->assignTo_email, $model->assignTo_fullname);
        if ($isAjax) {
					$data['success'] = true;
					$data['msg'][] = ['txt'=>$msg, 'type'=>'info'];
					if($mail!==true) $data['msg'][] = ['txt'=>$mail,'type'=>'danger'];
          return $this->asJson($data);
        }
				$ses->setFlash('info', $msg);
				if($mail!==true)
          $ses->setFlash('error', $mail);
      }else{
				if ($isAjax) {
					$data['success'] = false;
					$data['msg']= $model->getFirstErrors();
          return $this->asJson($data);
        }
				$ses->setFlash('info', json_encode($model->errors));
      }
    }

    $params = [
      'title'=>'Request Order',
      'model' => $model,
			'isOwner'=> $model->isOwner,
      'isAjax' => $isAjax,
      'redirect' => $this->httpRedirect
    ];

    if($isAjax){
      return $this->renderAjax('form', $params);
    }
    return $this->render('form', $params);
  }

  /**
   * Updates an existing Orders model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
	public function actionUpdate($id)
  {
		$req = Yii::$app->request;
		$isAjax = $req->isAjax;
    $model = $this->findModel($id);
		$isOwner = $model->isOwner;

    if(!$model->canEdit){
			if(!$model->canAttach)
				return $this->redirect(['order/view', 'id'=>$id]);
		}
	
		if($isOwner && ($model->isOpen || $model->isRejected)){
			$model->scenario = 'create';
		}
		else if($model->isAssigned){
			if($model->isOpen)
				$model->scenario = 'acceptation';
			else if($model->IsInprogress)
				$model->scenario = 'completion';
			else if($model->isComplete)
				$model->scenario = 'update-attach';
			else $model->scenario = 'commenting';
		}
		else {
			$model->scenario = 'commenting';
		}

    $post = $req->post();
    if($model->load($post)){
			if($isOwner && $model->status != $model::STATUS_OPEN){
				// throw new \yii\web\ForbiddenHttpException("Not valid request!");
				return $this->asJson(['success'=>false,'msg'=>'Not valid request!']);
			} 
			elseif($model->isAssigned){
				if($model->status == $model::STATUS_OPEN)
					return $this->asJson(['success'=>false,'msg'=>'Not valid request !']);
				elseif($model->status==$model::STATUS_REJECTED && !$post['Order']['comment'])
					return $this->asJson(['success'=>false,'msg'=>'Comment cannot be blank!']);
			}
			
			if($model->target_dt)
				$model->target_dt = date('Y-m-d H:i:s', strtotime($model->target_dt));
			$changeAttr = $this->getChangesAttr($model);
			$edited = count($changeAttr) ? 1 : 0;
			$sendEmail = true;
			if($model->scenario=='create' && $isOwner){
				$sendto = ['name'=>$model->assignTo_fullname, 'email'=>$model->assignTo_email, 'note'=>null];
				if($edited){
					$sendto['note'] = "Request Order Revision";
					// $model->status = $model::STATUS_OPEN;  // for automatic set
				}
				else{
					$sendEmail = isset($changeAttr['assign_to']) ? true : false; // send email if assigned changed
					// if(isset($changeAttr['id']) && !isset($changeAttr['assign_to'])){ // same assigned send notig changed id
						// $sendto['note'] = "Request Order Revision ID to ".$changeAttr['id'];
					// }
				}
			}
			elseif($model->scenario=='commenting'){
				$sendEmail = false;
			}
			else{
				if($model->scenario=='completion' && $model->status == $model::STATUS_REJECTED){
					$model->scenario = 'acceptation';
				}
				if($model->scenario=='acceptation'){
					if($model->status==$model::STATUS_ONPROGRESS)
						$data['redirect'] = \yii\helpers\Url::To(['/order/update', 'id'=>$model->id, 'scroll'=>'completion'], false);
					$sendto = ['name'=>$model->initiator_name, 'email'=>$model->initiator_email, 'note'=>null];
				}
				elseif($model->scenario=='completion'){
					$model->complete_at = date('Y-m-d', strtotime($model->complete_at));
					$model->complete_at_sys = date('Y-m-d h:i:s');
					$file=$this->uploadFile($model);
					$sendto = ['name'=>$model->initiator_name, 'email'=>$model->initiator_email, 'note'=>null];
					if($file!==true && $file){
						$data['msg'][] = ['txt'=>$file, 'type'=>'danger'];
					}
				}
				elseif($model->scenario=='update-attach'){
					$sendEmail = false;
					$file=$this->uploadFile($model);
					if($file!==true && $file){
						$data['msg'][] = ['txt'=>$file, 'type'=>'danger'];
					}
				}
			}

			if(!$edited){
				if(isset($post['Order']['comment']) && $post['Order']['comment']){
					$this->saveComment($model, $post);
					$msg = "Order <b>$model->id</b> has been updated.";
				}
				else{
					$msg = "No changes were made.";
				}
				return $this->asJson(['success'=>true,'msg'=>$msg]);
			}

			$transaction = Yii::$app->db->beginTransaction();
      if($model->save()){
				$this->saveComment($model, $post);
        $transaction->commit();   // NO INPUT TO DB
        
				
				if($model->scenario=='update-attach'){
					$msg = "Update Attachment for Order <b>$model->id</b>";
				}
				else {
					$msg = "Order <b>$model->id</b> has been " . (isset($changeAttr['status']) || $model->status==4 ? $this->getStatusText($model->status) : 'update.');
				}
				$this->log($msg);
				
				$mail = $sendEmail ? $this->sendMail($model, $sendto['email'], $sendto['name'], $sendto['note']) : true;
        if($isAjax) {
					$data['success'] = true;
					$data['msg'][] = ['txt'=>$msg, 'type'=>'info'];
					if($mail!==true) $data['msg'][] = ['txt'=>$mail,'type'=>'warning'];
          return $this->asJson($data);
        }
				$ses = Yii::$app->session;
        $ses->setFlash('info', $msg);
				if($mail!==true) $ses->setFlash('error', $mail);
      }else{
        $transaction->rollBack();
				if($isAjax){
					// if(YII_DEBUG) print_r($model->errors);
          return $this->asJson(['success'=>false,'msg'=>'Submit Failed. Please try again']);
				}
      }
    }

    $params = [
      'model' => $model,
      'title'=>"Request Order",
			'isOwner'=>$isOwner,
      'isAjax' => $isAjax,
      'redirect' => $this->httpRedirect
    ];

    if($isAjax){
      return $this->renderAjax('form', $params);
    }
    return $this->render('form', $params);
  }
	
	protected function getStatusText($st){
		if($st==1) return "rejected.";
		elseif($st==2) return "updated.";
		elseif($st==3) return "accepted.";
		elseif($st==4) return "completed.";
	}
	
	protected function saveComment($order, $post){
		if(isset($post['Order']['comment'])){
			$comment = new \app\models\Comment();
			$comment->comment = $post['Order']['comment'];
			$comment->order_id = $order->id;
			$comment->user_id = Yii::$app->user->id;
			$comment->context_id = $order->status;
			$comment->save();
		}
	}
	
  /**
   * Deletes an existing Orders model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionDelete($id)
  {
    $model = $this->findModel($id, true);
    $item = $model->id;

    if($model->delete()){
      $msg = "Delete Order $item";
      $this->log($msg);
      if(Yii::$app->request->isAjax){
        return $this->asJson(['success' => true, 'msg'=>$msg]);
      }
      Yii::$app->session->setFlash('info', $msg);
      return $this->redirect(\yii\helpers\Url::previous());
    }
  }
	
	protected function sendMail($model, $mail_to, $mail_name, $note=null)
	{
		if(Yii::$app->params['mail_disabled'])
			return true;
		
		$act = $model->canEdit ? '/order/update' : '/order/view';
		$params = [
			'mail_name'=>$mail_name,
      'no'=>$model->id,
      'date'=>$model->create_at, //date('Y-m-d H:i:s'), 
      'link'=>\yii\helpers\Html::a($model->id, \yii\helpers\Url::To([$act, 'id'=>$model->id], true), ['class'=>'link','target'=>'_blank']),
      'desc'=>$model->detail_desc,
			'status'=>$model->status,
			'initiator'=>$model->initiator_name,
			'note'=>$note
    ];
		
		try{
			$send = Yii::$app->mailer->compose('request-order', $params)
				->setFrom([\Yii::$app->params['mail']['senderEmail']=>\Yii::$app->params['mail']['senderName']])
				->setTo($mail_to)
				->setSubject('Request Order')
				->send();
			if(!$send) return "Can't send email this time";
			return $send;
		}catch(\Exception $e){
			return YII_DEBUG ? $e->getMessage() : "Can't send email this time";
    } catch(\Throwable $e) {
      return YII_DEBUG ? $e->getMessage() : "Can't send email this time";
    }
  }
	
	protected function uploadFile($model){
		// $model->attachment->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
		if(!isset($_FILES['Order'])) return false;
		if($_FILES['Order']['error']['attachment']==UPLOAD_ERR_OK){
			$file = $_FILES['Order']['name']['attachment'];
			$attr = explode('.',$file);
			if(isset($attr[1])){
				$name = $attr[0];
				$ext = $attr[1];
			}
			else return "Unknown file type.";
			$file = $model->id.".".$ext;
			// if(file_exists($dir . $file)) echo $file . " already exists. ";
			try{
				if(move_uploaded_file($_FILES['Order']['tmp_name']['attachment'], $model::UPLOAD_DIR.$file)){
					$model->attachment = $file; //echo $model->attachment; die();
					// if($model->isInprogress) $model->status = $model::STATUS_COMPLETE; // set it for mandatory
					return true;
				}
			}catch(\Exception $e){
				return YII_DEBUG ? $e->getMessage() : "file Upload failed.";
			}
		}
		return "file Upload failed.";
	}
	
	public function actionSuggest()
  {
		$searchModel = new OrderSearch();
    $dataProvider = $searchModel->list_search();
    $response = \Yii::$app->response;
    $response->format = \yii\web\Response::FORMAT_JSON;
		$response->data = $dataProvider->asArray()->all();
  }
	
	# debug must disable
	public function actionPrint1($id=null)
	{
		if($id)
			$model = $this->findModel($id);
		else{
			$model = new Order();
			$model->scenario = "create";
			$id = "New Order";
		}
		
		$req = Yii::$app->request;
		if(!($model->status > $model::STATUS_OPEN && ($model->IsAssigned || Yii::$app->user->identity->isAdmin))){
			if($req->isAjax){
				return $this->asJson(['error'=>'You are not allowed for this request']);
			}else
				throw new \yii\web\ForbiddenHttpException("You are not allowed for this request");
		}
		
		if($model->status==$model::STATUS_ONPROGRESS)
			$model->status=null;
		if($model->complete_at)
			$model->complete_at = date('Y-m-d', strtotime($model->complete_at));
		
		$html = $this->renderFile('@app/views/order/print_pdf.php', ['model'=>$model, 'title' =>'Report Request Order']);
		echo $html; die();
			
		try {
			$descriptorspec = array(
				0 => array('pipe', 'r'), // stdin
				1 => array('pipe', 'w'), // stdout
				2 => array('pipe', 'w'), // stderr
			);

			$cmd = \Yii::$app->params['pdf_path'] . ' -q --footer-font-size 7 --footer-font-name italic --footer-left "Page [page] of [toPage]" --footer-right "'.date('d.m.Y h:i:s').'" --javascript-delay 1500 - -';
			$process = proc_open($cmd, $descriptorspec, $pipes, null, null, array('bypass_shell'=>true)); // win2003
			
			// Linux
			// $pipes = array();
			
			// Send the HTML on stdin
			fwrite($pipes[0], $html);
			fclose($pipes[0]);

			// Read the outputs
			$pdf = stream_get_contents($pipes[1]);  //var_dump($pdf); die();
			$errors = stream_get_contents($pipes[2]); //var_dump($errors); die();
			// Close the process
			fclose($pipes[1]);
				$return_value = proc_close($process);
			if(!$errors) {
				header('Content-Type: application/pdf');
				header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
				header('Pragma: public');
				header('Expires: 0'); // Date in the past
				header('Content-Length: ' . strlen($pdf));
				header('Content-Transfer-Encoding: binary');
				header('Content-Disposition: attachment; filename="' . $id . '.pdf";');
				//header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
				//header("Content-Type: binary/octet-stream");

				echo $pdf;
				// readfile("./file.txt");
				exit();
			}
		}catch(\Exception $e){
			$errors = $e->getMessage();
    }

		if(isset($errors)){
			if($req->isAjax){
				$response = \Yii::$app->response;
				$response->format = \yii\web\Response::FORMAT_JSON;
				$err = YII_ENV_DEV ? $errors : "PDF generation failed!";
				$response->data = array('error'=>$err);
			}else{
				// return Yii::$app->session->setFlash('warning', $errors));
				echo $errors;
			}
		}
	}
	
	public function actionPrint($id=null)
	{
		if($id)
			$model = $this->findModel($id);
		else{
			$model = new Order();
			$model->scenario = "create";
			$id = "Request Order";
		}
		
		$html = $this->renderFile('@app/views/order/print_pdf2.php', ['model'=>$model, 'title' =>'Report Request Order']);
		// echo $html; die();
		
		$options = new Options();
		$options->set('isHtml5ParserEnabled', true);
		$options->set('isRemoteEnabled', true);
		$options->set('isJavascriptEnabled', true);
		$options->setPdflibLicense("asasasa");
		
		// instantiate and use the dompdf class
		$dompdf = new Dompdf($options);
		$dompdf->loadHtml($html);
		// $html = $dompdf->output_html();
		// $dompdf->loadHtml($html);
		
		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('A4', 'portrait');
		
		// Render the HTML as PDF
		$dompdf->render();

		$canvas = $dompdf->get_canvas();
		$canvas->javascript("document.getElementById('test').innerText = 'xxxx'");
		// $canvas->javascript("window.print();");
		
		$font = $dompdf->getFontMetrics()->get_font("helvetica", "normal");
		$canvas->page_text(35, 800, date('d.m.Y h:i:s'), $font, 8, array(0,0,0));
		$canvas->page_text(520, 800, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0,0,0));
		
		// Output the generated PDF to Browser
		$dompdf->stream("RO-".$id, array('Attachment'=>0));
	}

  /**
   * Finds the Orders model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return Orders the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id, $isDelete=false)
  {
    if($isDelete){
      $query = Order::findOne($id);
    }else{
      $query = Order::find()
      ->select(['orders.*', 'u1.email as initiator_email','u1.uname as initiator_name','d1.label as initiator_dept','u2.uname as assignTo_name','u2.fullname as assignTo_fullname','u2.email as assignTo_email','d2.label as assignTo_dept','tag.tagnum as tag_name','area.label_a as area_name','ehs_ass.label as ehs_ass_name'])
			->join('LEFT JOIN', 'tag', 'orders.tag_num = tag.tagnum')
      ->join('LEFT JOIN', 'area', 'orders.area = area.label_a')
      ->join('LEFT JOIN', ['u1'=>'users'], 'orders.initiator_id = u1.id')
      ->join('LEFT JOIN', ['u2'=>'users'], 'orders.assign_to = u2.id')
      ->join('LEFT JOIN', ['d1'=>'dept'], 'u1.dept_id = d1.id')
      ->join('LEFT JOIN', ['d2'=>'dept'], 'u2.dept_id = d2.id')
      ->join('LEFT JOIN', 'ehs_ass', 'orders.ehs_assest = ehs_ass.id')
			// ->join('LEFT JOIN', 'region', 'orders.region_id = region.id')
			// ->join('LEFT JOIN', 'priority', 'orders.priority = priority.id')
      ->where('orders.id=:id')->addParams([':id'=>$id])->one(); //->asArray()->one();
    }

    if ($query !== null) {
      return $query;
    }
    throw new NotFoundHttpException('The requested data does not exist.');
  }

	/**
	* Fecth suggestion for data tags
	**/
	public function actionTagSuggest()
  {
		$req = Yii::$app->request;
    $q = $req->post('q');
    if(preg_match(self::REGEX_SQLI, $q)) return;
    $query = "SELECT tag.id, tag.tagnum, tag.desct, tag.area_id, area.label_a as area FROM tag LEFT JOIN area ON area.id = tag.area_id";
    if($q){
			$query .= " WHERE tagnum LIKE :tag OR desct LIKE :tag2";
			$rs = \Yii::$app->db->createCommand($query)->bindValue(':tag', "%$q%")->bindValue(':tag2', "%$q%")->queryAll();
		}else{
			$rs = Yii::$app->cache->getOrSet('tags', function() use($query){
				return \Yii::$app->db->createCommand($query)->queryAll();
			});
		}

    $arr = ['id' => '', 'tagnum' => 'Other'];
    $rs = array_merge($rs, [$arr]);

    if($req->isAjax){
      $response = \Yii::$app->response;
      $response->format = \yii\web\Response::FORMAT_JSON;
      $response->data = $rs;
    }else{
      $list =  \yii\helpers\ArrayHelper::map($rs, 'id', 'tagnum');
      \yii\helpers\VarDumper::dump($list, 10, true);
			exit();
    }
  }
	
	/**
	* Fecth suggestion for data users
	**/
	public function actionUserSuggest()
  {
    $rs = Yii::$app->cache->getOrSet('user', function () {
      return \Yii::$app->db->createCommand("select users.id, users.uname, users.fullname, users.email, dept.label as dept from users left join dept on users.dept_id=dept.id WHERE users.status=1 and uname !='admin'")->queryAll();
    });
    $data=[];
    foreach($rs as $k => $v){
      if($v['id'] == Yii::$app->user->id) continue;
      array_push($data, $v);
    }
    $response = \Yii::$app->response;
    $response->format = \yii\web\Response::FORMAT_JSON;
    $response->data = $data;
  }
	
	
	/**
	* Fecth data type legend
	**/
	public function actionGetTypeLegend(){
		$data = \app\models\OrderType::getList('legend');
		$response = \Yii::$app->response;
    $response->format = \yii\web\Response::FORMAT_JSON;
    $response->data = $data;
	}
	
	/**
	* Validation submit form
	**/
	protected function performAjaxValidation($model){
    if(Yii::$app->request->isAjax) {
      $data = $model->errors;
			$res = Yii::$app->response;
      $res->format = \yii\web\Response::FORMAT_JSON;
			$res->data  = count($data) ? $data : array('success'=>1);
			$res->send();
			Yii::$app->end();
    }
	}

}
