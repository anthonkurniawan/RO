<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class SiteController extends MainController
{
  /**
   * {@inheritdoc}
   */
  public function behaviors()
  {
    return [
      'access'=>[
        'class'=>AccessControl::className(),
        'only'=>['login','logout','index','register','register-find-user','confirm','recover','get-ldap-user','login_ldap'],
				'rules'=>[
          [
						'actions'=>['login','register','register-find-user','confirm','recover','login_ldap'],
            'allow'=>true,
            'roles'=>['?'],
          ],
          [
            'actions'=>['index','logout','login_ldap'],
            'allow'=>true,
            'roles'=>['@'],
          ],
					[
            'allow' => true,
            'actions' => ['get-ldap-user'],
            'matchCallback' => function ($rule, $action) {
              return Yii::$app->user->identity && Yii::$app->user->identity->isAdmin;
             }
          ],
        ],
      ],
      'verbs'=>[
        'class'=>VerbFilter::className(),
        'actions'=>[
          'logout'=>['post'],
					'register-find-user'=>['post'],
					// 'get-ldap-user'=>['post']
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function actions()
  {
    return [
      'error'=>[
        'class'=>'yii\web\ErrorAction',
      ],
      'captcha'=>[
        'class'=>'yii\captcha\CaptchaAction',
        'fixedVerifyCode'=>YII_ENV_TEST ? 'testme' : null,
      ],
    ];
  }

  /**
   * Displays homepage.
   *
   * @return string
   */
  public function actionIndex()
  {
		\yii\helpers\Url::remember();
    $req = Yii::$app->request;
    $searchModel = new \app\models\OrderSearch();
    $dataProvider = $searchModel->list_search();
    if($req->isAjax){
      return $this->renderAjax('index', ['dataProvider'=>$dataProvider,]);
    }
    return $this->render('index', ['dataProvider'=>$dataProvider,]);
  }
	
  /**
   * Login action.
   *
   * @return Response|string
   * actionLogin -> LoginForm -> yii/web/User->login( app\models\User ) -> bool
   */
  public function actionLogin()
  {
    if (!Yii::$app->user->isGuest) {
      return $this->goHome();
    }

    $model = new \app\models\LoginForm(['scenario'=>'login']);
    if ($model->load(Yii::$app->request->post())) {
      $this->performAjaxValidation($model);
      if($model->login()){
        Yii::$app->db->createCommand('Update users set last_loged='.time().' WHERE id='.Yii::$app->user->id)->execute();
        if(Yii::$app->user->identity->IsSysAdmin)
					Yii::$app->session->setFlash('default', 'Welcome back sir.. ;)');
        
				$url = Yii::$app->user->returnUrl;
				if(preg_match("/print|pdf|exl/", $url))
					return $this->goHome();
				else
					return $this->goBack();
      }
      if($model->errors){
        foreach($model->errors as $k=>$v){
          Yii::$app->session->setFlash('warning', $k.": ".$v[0]);
        }
      }
    }
    return $this->render('login', ['model'=>$model]);
  }
	
	/**
   * Register action.
   *
   * @return Response|string
   * actionLogin -> LoginForm -> yii/web/User->login( app\models\User ) -> bool
   */
	public function actionRegister_OLD()
  {
		if(!Yii::$app->params['allow_self_register']) {
			return $this->render('/site/error', [
				'name'=>'Not Found',
				'message'=>"Page not found."
			]);
		}
		
    if (!Yii::$app->user->isGuest) {
      return $this->goHome();
    }
		
    $model = new app\models\RegisterForm(['scenario'=>'register']);
    if($model->load(Yii::$app->request->post())) {
			$model->role = $model::ROLE_INITIATOR;
      $this->performAjaxValidation($model);
			
      if($model->register()){
				$msg = "<h4>Registration Successfully</h4> Your account has been created.";
				if(Yii::$app->session->hasFlash('mail-error')){
					//Yii::$app->session->getFlash('mail-error');
					$msg .= "With failure on sending email.<br>Please Contact your administrator to confirm your registration.<br>Or click link below to "
						.\yii\helpers\Html::a('Resend Email', 'resend',['style'=>'text-decoration:underline;font-weight:bold']);
				}else{
					$msg .= '<br>Please check your email to verify your account';
				}
		
        Yii::$app->session->setFlash('info', "Registration sucessfully..");
        return $this->goHome();
      }

      if($model->errors){
        foreach($model->errors as $k=>$v){
          Yii::$app->session->setFlash('warning', $k .": ". $v[0]);
        }
      }
    }
    return $this->render('register', ['model'=>$model, 'ldap_enable'=>\Yii::$app->params['ldap_enable']]);
  }
	
	public function actionRegister()
  {
		if(!Yii::$app->params['allow_self_register']) {
			return $this->render('/site/error', [
				'name'=>'Not Found',
				'message'=>"Page not found."
			]);
		}
		
    if (!Yii::$app->user->isGuest) {
      return $this->goHome();
    }
		
    $model = new \app\models\RegisterForm(['scenario'=>'register']);
    if($model->load(Yii::$app->request->post())) {
			$model->role = $model::ROLE_INITIATOR;
      $this->performAjaxValidation($model);
			
			$need_confirm = Yii::$app->params['confirm_mail_onRegister'];
			if($need_confirm) $model->status = $model::STATUS_INACTIVE;
			$model->updatePassword($model->password);

			if($need_confirm)
				$ok = $this->sendConfirmEmail($model->uname, $model->email, $model->access_token, 'confirmation');
			else
				$ok = 1;
	
			if($ok && $model->save()){
				$this->log("Register #$model->uname");
				Yii::$app->session->setFlash('info', "Registration sucessfully..");
				if($need_confirm){
					return $this->render('register_success', ['email'=>$model->email,'token'=>$model->access_token]);
				}
				else{
					if(Yii::$app->user->login($model, 0))
						return $this->goHome();
				}
			} 
    }
    return $this->render('register', ['model'=>$model, 'ldap_enable'=>\Yii::$app->params['ldap_enable']]);
  }
	
	public function actionRegisterFindUser(){
		$uname = $_POST['RegisterForm']['uname'];
		$pass = $_POST['RegisterForm']['password'];
		if($uname && $pass){
			$ldap = new \app\models\LDAP($uname, $pass);
			$data = $ldap->getUserArray($uname);
			if($data){
				return $this->asJson(['success'=>true,'msg'=>$data,'ldap'=>$ldap]);
			}else{
				$err = $ldap->getFirstError('ldap');
				if(!$err) $err = 'Unknow Error. Please try again.';
				return $this->asJson(['success'=>false, 'msg'=>$err]);
			}
		}else {
			return $this->asJson(['success'=>false, 'msg'=>'Incorrect username or password']);
		}
	}
	
	public function actionResendMail($uname, $email, $token, $template='recovery'){
		$this->sendConfirmEmail($uname, $email, $token, $template);
		return $this->render('register_success', ['email'=>$email,'token'=>$token]);
	}
	
	public function sendConfirmEmail($uname, $email, $token, $template){
    $url = \yii\helpers\Url::To(['/site/confirm', 'token'=>$token], true);
    $params = [
			'name'=>$uname,
      'link'=> \yii\helpers\Html::a(\yii\helpers\Html::encode($url), $url, ['target'=>'_blank']),
    ];
		
		try{
			$mailer = Yii::$app->mailer;
			return $mailer->compose($template, $params)
				->setFrom([\Yii::$app->params['mail']['senderEmail']=>\Yii::$app->params['mail']['senderName']])
				->setTo($email)
				->setSubject('RO-Email Confirmation')
				->send();
		} catch(\Exception $e){
			$msg = YII_ENV_DEV ? $e->getMessage() : "Email failed to send. Try it again..";
			Yii::$app->session->setFlash('error', $msg);
		}
  }
	
	public function actionConfirm($token){
		$user = \app\models\User::findIdentityByAccessToken($token);
		
		if($user){
			$user->status = $user::STATUS_ACTIVE;
			$user->access_token = NULL;
			if($user->save(false) && Yii::$app->user->login($user, 0)){
				Yii::$app->session->setFlash('info', "Welcome $user->uname");
				return $this->goHome();
			}
		}
		else{
			return $this->render('/site/error', [
				'name'=>'Token Invalid',
				'message'=>"Can not validate or your registration token has expired.\nPlease login or register again."
			]);
		}
	}

	public function actionRecover(){
		$model = new \app\models\User(['scenario'=>'recovery']);
    if($model->load(Yii::$app->request->post())) {
			$user = $model::findByEmail($model->email);
			if($user){
				$user->generateAccessToken();
				if($user->save() && $this->sendConfirmEmail($user->uname, $user->email, $user->access_token, 'recovery'))
					return $this->render('recovery_success', ['uname'=>$user->uname, 'email'=>$user->email,'token'=>$user->access_token]);
			}
			else $model->addError('email', 'You are not registered in this system.');
		}
		return $this->render('recovery', ['model'=>$model]);
	}
	
	public function getLdapUser($ldap, $isAjax, $search=""){
		if($search){
			// $auth = $ldap->getUser();
			// $data = $ldap->formatData($auth);
			if($search=="*") $search = "";
			$data = $ldap->getUserArray($search);
		} else {
			$data = $ldap->auth();
		}
		if ($isAjax){
			if($data)
				return $this->asJson(['success'=>true, 'msg'=>$data, 'ldap'=>$ldap]);
			else
				return $this->asJson(['success'=>false, 'msg'=>$ldap->getFirstError('ldap')]);
		}				
	}
	
	/**
	* for auth verbose=0 && fecthing data verbose=1
	**/
	public function actionLogin_ldap($search=0, $verbose=0){
		$request = Yii::$app->request;
		$isAjax = $request->isAjax;
		$ldap = new \app\models\LDAP();
	
		if ($ldap->load(Yii::$app->request->post())) {
			return $this->getLdapUser($ldap, $isAjax, $search);	
		}
		
		$params = array('model'=>$ldap, 'showUsernameInput'=>1, 'verbose'=>$verbose, 'isAjax'=>$isAjax);
		if($isAjax)
      return $this->renderAjax('login_ldap', $params);
    else
      return $this->render('login_ldap', $params);
	}
	
	public function actionGetLdapUser() {
		$request = Yii::$app->request;
		$isAjax = $request->isAjax;
		$ldap = new \app\models\LDAP(Yii::$app->user->identity->uname);
		
		if ($ldap->load(Yii::$app->request->post())) {
			return $this->getLdapUser($ldap, $isAjax, "*");
		}
		
		$params = array('model'=>$ldap, 'showUsernameInput'=>0, 'verbose'=>0, 'isAjax'=>$isAjax);
		if($isAjax)
      return $this->renderAjax('login_ldap', $params);
    else
      return $this->render('login_ldap', $params);
	}
	
  /**
   * Logout action.
   *
   * @return Response
   */
  public function actionLogout()
  {
    Yii::$app->user->logout();
    return $this->goHome();
  }

  /**
   * Displays contact page.
   *
   * @return Response|string
   */
  public function actionContact()
  {
    $model = new ContactForm();
    if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
      Yii::$app->session->setFlash('contactFormSubmitted');

      return $this->refresh();
    }
    return $this->render('contact', [
      'model'=>$model,
    ]);
  }

  /**
   * Displays about page.
   *
   * @return string
   */
  public function actionAbout()
  {
    return $this->render('about');
  }
}
