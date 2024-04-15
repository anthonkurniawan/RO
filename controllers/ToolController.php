<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class ToolController extends MainController
{
  public function behaviors()
  {
    return [
      'access' => [
        'class' => AccessControl::className(),
        'rules' => [
          [
            'allow' => true,
            'actions' => ['check_ldap','test-mail','flush','print-xls','print-pdf','backup','test-php-mailer'],
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
	
	public function actionBackup_OLD()
  {
		if(Yii::$app->db->driverName=='mysql'){
			return $this->render('/site/error', [
				'name'=>'Not Supported',
				'message'=>"Only works with sql server for now. Mysql not yet supported."
			]);
		}
	
		$backup_loc = Yii::$app->params['backup_location'];
		if($_POST && $_POST['do-backup']){
			$filename = preg_replace("/\\\\\\\/", "\\", $backup_loc);
			try{
				$rs = Yii::$app->db->createCommand("backup database ro to disk='$filename'")->query();
			} catch (\Exception $e){
				$rs = 0;
				$msg = $e->getMessage();
			}
			
			if($rs){
				$this->log("Backup database");
				return $this->asJson(['success' => true, 'msg'=>"Backup database success"]);
			}else{
				return $this->asJson(['success' =>false, 'msg'=>$msg]);
			}
		}
		else{
			$data = Yii::$app->db->createCommand("EXEC backupLog")->queryAll();
			return $this->render('backup', ['data'=>$data, 'backup_loc'=>$backup_loc, 'redirect'=>$this->httpRedirect]);
		}
	}
	
	public function actionBackup(){
		$backup_loc = Yii::$app->params['backup_location'];
		if($_POST && $_POST['do-backup']){
			$cmd = 'sqlcmd.exe -U admin -P belang@9 -Q "EXEC ro.dbo.SP_BACKUP"';
			$descriptorspec = array(
				0 => array('pipe', 'r'), // stdin
				1 => array('pipe', 'w'), // stdout
				2 => array('pipe', 'w'), // stderr
			);
			$process=proc_open($cmd, $descriptorspec, $pipes);
			// fwrite($pipes[0]);
			fclose($pipes[0]);

			// Read the outputs
			$out = stream_get_contents($pipes[1]);
			$err = stream_get_contents($pipes[2]);
			fclose($pipes[1]);
			$p = proc_close($process);

			$rs = strpos($out, 'successfully');
			
			if($rs > 0){
				$this->log("Backup database");
				return $this->asJson(['success' => true, 'msg'=>"Backup database success"]);
			}else{
				return $this->asJson(['success' =>false, 'msg'=>$out]);
			}
		}
		else{
			$data = Yii::$app->db->createCommand("EXEC backupLog")->queryAll();
			return $this->render('backup', ['data'=>$data, 'backup_loc'=>$backup_loc, 'redirect'=>$this->httpRedirect]);
		}

	}
	
  public function actionCheck_ldap()
  {
		$ldap = new \app\models\LDAP_Tool();
		$ldap->filter = $ldap::FILTER_ALL;
    $data = null;
		$data_format = null;
    if ($ldap->load(Yii::$app->request->post())) {
			$regex = "/w2003dns\\\+/";  // "/apac\\\+/"
			$ldap->uname = preg_replace($regex, "", $ldap->uname); 
			$data = $ldap->getData();
			$data_format = $ldap->formatData($data);
    }
    return $this->render('check_ldap', ['model' => $ldap, 'data'=>$data, 'data_format'=>$data_format]);
	}
	
	public function testLdap($model){
		$ldap_ip = \Yii::$app->params['ldap_server_ip'];
		$ldap_port = \Yii::$app->params['ldap_server_port'];
		$ldap_h = gethostbyaddr($ldap_ip);
		$host = gethostbyname($ldap_h);
		echo "<br><br><br>LDAP IP : $host, DNS : $ldap_h  ";
		$dc = preg_match("/^[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,10}$/", $ldap_h);
		$dn = "";
		if(!$dc) {
			echo " (DN not found. Search not available.)<br>";
			try{
				$op = fsockopen($ldap_ip, $ldap_port, $errno, $errstr);
				echo "DC OK $op (can login)";
				$dc = 1;
				fclose($op);
			} catch(\Exception $e){
				echo "DC NOT AVAILABLE! (errno:$errno .- $errstr)";
			}
		}
		else {
			$dn = $this->parseDn($ldap_h);
		}

		$server = array(
			$model->server, 
			\Yii::$app->params['ldap_server_ip'], 
			$ldap_h
		);
		$username = array(
			$model->uname, 
			$ldap_h."\\".$model->uname,
			$model->server."\\".$model->uname, 
			$model->uname.'@'.\Yii::$app->params['ldap_server_dns']
		);
		print_r($server); echo "<br>"; 
		print_r($username); echo "<br>"; 
		
		echo "Testing connect($model->server)<br>";
		$con = ldap_connect($ldap_h);
		try {
			$auth = ldap_bind($con, $model->uname.'@mydns.test.id', $model->pass);  // ok
			// $auth = ldap_bind($con, 'mydns\\'.$ldap->uname, $ldap->pass);  // ok
			echo "ldap_bind()<br>";
			printf("=>%d<br>", $auth);
		}catch(\Exception $e){
			echo $e->getMessage();
			// $model->addError('ldap', preg_replace('/[\'\"]/',"\\'", $e->getMessage()));
		}
		
		foreach($server as $svr){
			$con = ldap_connect($svr);
			echo "<br>Testing connect(\"$svr\") $con<br>";
			foreach($username as $user){
				echo " > ldap_bind(\"$user\")";
				try {
					$auth = ldap_bind($con, $model->uname, $model->pass);
					echo " $auth";
					$dn = "CN=Users, DC=mydns, DC=test, DC=ID"; 
					// $dn = "CN=Users, DC=WIN2003"; 
					$rs = ldap_search($con, $dn, $model->filter);
					$data = ldap_get_entries($con, $rs);
					echo "<br>&nbsp;&nbsp;&nbsp;ldap_search(\"$dn\"): " . $rs .", ldap_get_entries: ". (isset($data['count']) ? $data['count'] : count($data))."<br>";
				}catch(\Exception $e){
					echo "<span style='color:red;margin-left:10px'>" . $e->getMessage() . "</span><br>";
				}
			}
			ldap_close($con);
		}
	}
	
	protected function parseDn($dn){
		$parts = explode('.', $dn);
		$dn="";
		for($i=0; $i < count($parts); $i++){
			$dn .= "DC=$parts[$i]" . ($i < count($parts)-1 ? ", ":"");
		}
		return $dn;
	}
	
	// lookup port default
	protected function chkPortService(){
		$services = array('http', 'ftp', 'ssh', 'telnet', 'imap','smtp', 'nicname', 'gopher', 'finger', 'pop3', 'www', 'ldap');
		foreach ($services as $service) {
			$port = getservbyname($service, 'tcp');
			echo $service . ": " . $port . "<br />\n";
		}
	}
	
	public function actionTest____()
  {
		$cfg = Yii::$app->params;
    $server = $cfg['ldap_server_dns'] ? $cfg['ldap_server_dns'] : $cfg['ldap_server_ip'];
		$ldap = ldap_connect('192.168.56.3');  // 192.168.56.3'
		// print_r($ldap);
		ldap_bind($ldap, "admin", "belang");
		
    // ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
		// try{
			// // $rs = ldap_search($ldap, "cn=".$this->uname.", cn=users, DC=".$server.", DC=COM", "(objectClass=*)");
			// $rs = ldap_search($ldap, "cn=bambang, cn=users, DC=".$server.", DC=COM", "(objectClass=*)");
			// $data = ldap_get_entries($ldap, $rs);
			// ldap_close($ldap);
			// print_r($data);
			// return $data;
    // }catch(\Exception $e){
      // $err2 = preg_replace('/[\'\"]/',"\\'", $e->getMessage());
    // } catch(\Throwable $e) {
      // $err2 = preg_replace('/[\'\"]/','\\"', $e->getMessage());
    // }
		// print_r($err2);
		
		
		// $ldapuri = "ldap://192.168.56.3:389";  // your ldap-uri
		// $ldap = ldap_connect($ldapuri)
          // or die("That LDAP-URI was not parseable");
		// print_r($ldap);
		
		// $dn = "o=w2003dns, c=ID";  // EEROR
		// $dn = "cn=$this->uname,ou=People,dc=example,dc=com";  // SLAX
		// $dn = 'cn=admin, ou=People, dc=w2003dns, dc=com';  // ERROR: No such object
		$dn = 'CN=Users, DC=W2003DNS, DC=COM';  // get all users
		// $dn = "cn=admin, cn=users, dc=w2003dns, dc=com";

		// $filter="(|(sn=Kur*)(givenname=Ant*))";
		$filter="(objectClass=person)";
		// $filter = "(&(objectClass=user)(sAMAccountName=%s))";
		// $justthese = array("ou", "sn", "givenname", "displayname", "mail");
		$justthese = array("sn", "givenname", "displayname", "mail");
		// $justthese = array("sn");
		
		// $rs = ldap_search($ldap, "cn=bambang, cn=users, DC=$server, DC=COM", "(objectClass=*)");
		$sr = ldap_search($ldap, $dn, $filter, $justthese);
		$data = ldap_get_entries($ldap, $sr);
		ldap_close($ldap);
		// return \yii\helpers\VarDumper::dump($data, 10, 1);
		// echo $data[0]['sn'][0] . "<br>";
		// echo $data[0]['givenname'][0] . "<br>";
		// echo $data[0]['displayname'][0] . "<br>";
		// echo $data[0]['mail'][0] . "<br>";
		
		// $user = array(
			// 'uname'  =>$data[0]['displayname'][0],
			// 'firstname' =>$data[0]['givenname'][0],
			// 'lastname'  =>$data[0]['sn'][0],
			// 'email'     =>$data[0]['mail'][0],
		// );

		$users = array();
		foreach($data as $v) {
			if(!isset($v['givenname'])) continue;
			
			$uname = $v['displayname'][0];
			$fname = isset($v['givenname'][0]) ? $v['givenname'][0] : "";
			$lname = isset($v['sn'][0]) ? $v['sn'][0] : "";
			$email = isset($v['mail'][0]) ? $v['mail'][0] : "";
			
			$users[$uname] = array(
				'uname'  =>$uname,
				'firstname' =>$fname,
				'lastname'  =>$lname,
				'email'     =>$email
			);
		}
		\yii\helpers\VarDumper::dump(array_key_exists('admin', $users));
		\yii\helpers\VarDumper::dump($users, 10, 1);
		
		return;
  }

  public function actionTestMail()
  {
    $params = ['content' => 'test..'];
    $params = [
      'mail_name'=>'Honey..',
      'no' => '121232323',
      'date' => date('Y-m-d H:i:s'),
      //'link'=> \yii\helpers\Html::a('121232323', ['/order/view', 'id'=>'121232323'], ['target'=>'_blank']),
      'link'=> \yii\helpers\Html::a('TEST', \yii\helpers\Url::To(['/order/view', 'id'=>'01122021001'], true), ['target'=>'_blank']),
      'desc'=>'aljsa;jsajs;asjas als;lask;laksaksk asjaksjkajskajs alsjalsjajsajs alsjaksjasjkajs asasasas asasasas asasasa asasasas asasasaa;aks;ka;sk;as asla;sl;al;slas a;sl;asl;asl;as;als asl;als;asl;als;a;sl sdsjdksjdkskdjskjdksd sdsjdlsjdlsjldsljd sldlsdlskldk',
			'status'=>1,
			'initiator'=>'test iniator name',
			'note'=>NULL
		];
			
    // $string = Yii::$app->mailer->render('path/to/view', ['params' => 'foo'], 'path/to/layout');
		$mailer = Yii::$app->mailer;
		// return $mailer->render('request-order', $params, '@app/mail/layouts/html');
		
    $mail = $mailer->compose('request-order', $params)
      // ->setFrom(\Yii::$app->params['mail']['senderEmail'])
			->setFrom(['anthon.awan@gmail.com'=>'test'])
      // ->setTo('blaquecry@gmail.com')
			// ->setTo(['blaquecry@gmail.com' => 'New Mailtrap user'])
			->setTo(['anthon.awan@gmail.com' => 'New Mailtrap user'])
      ->setSubject('test-subject')
      //->toString();
      ->send();
     return \yii\helpers\VarDumper::dump($mail, 10, 1);
		 exit();
  }
	
	public function actionTestPhpMailer(){
		include "../phpmailer/classes/class.phpmailer.php";
		$mail = new \PHPMailer;

		$mail->IsSMTP();

		$mail->SMTPSecure = 'tls';
		$mail->Host = 'smtp.gmail.com';
		$mail->SMTPDebug = 2;
		$mail->Port = 587; // 465;
		$mail->SMTPAuth = true;
		$mail->Timeout = 60; // timeout sending (in sec)
		$mail->SMTPKeepAlive = true;
		
		//Ask for HTML-friendly debug output
		$mail->Debugoutput = 'html';
		$mail->isSMTP();

		$mail->Username = 'anthon.awan@gmail.com'; // "admin@namadomain"; //user email
		$mail->Password = "cqrswrbsomtmhddi"; //password email
		$mail->SetFrom("anthon.awan@gmail.com", "Nama"); //set email pengirim
		$mail->Subject = "subyek email";
		$mail->AddAddress("blaquecry@gmail.com", "Nama"); //tujuan email
		$mail->MsgHTML("Pengiriman Email Dari Website");

		if($mail->Send()) echo "Message has been sent";
		else echo "Failed to sending message";
	}

  public function actionFlush()
  {
    $cache = Yii::$app->cache;
    \yii\helpers\VarDumper::dump($cache, 10, 1);

    $flush = $cache->flush();
		return \yii\helpers\VarDumper::dump($flush, 10, 1);
  }

  public function actionPrintXls()
  {
    return $this->_printXls('../runtime/test.html', 'Test XLS');
  }

  public function actionPrintPdf()
  {
    $html = $this->renderFile('../runtime/test.html'); //echo $html; die();
    $descriptorspec = array(
      0 => array('pipe', 'r'), // stdin
      1 => array('pipe', 'w'), // stdout
      2 => array('pipe', 'w'), // stderr
    );

    $iden = Yii::$app->user->getIdentity();
    $uname = $iden ? $iden->uname : 'Guest';

    // Linux
    $process = proc_open('wkhtmltopdf -q --javascript-delay 1000 - -', $descriptorspec, $pipes);

    // Send the HTML on stdin
    fwrite($pipes[0], $html);
    fclose($pipes[0]);

    // Read the outputs
    $pdf = stream_get_contents($pipes[1]);  //var_dump($pdf); die();
    $errors = stream_get_contents($pipes[2]); //var_dump($errors); die();
    // Close the process
    fclose($pipes[1]);
    $return_value = proc_close($process);
    if ($errors) {
      throw new \Exception('PDF generation failed: ' . $errors);
    } else {
      header('Content-Type: application/pdf');
      header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
      header('Pragma: public');
      header('Expires: 0'); // Date in the past
      //header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
      header('Content-Length: ' . strlen($pdf));
      header('Content-Transfer-Encoding: binary');
      header('Content-Disposition: attachment; filename="test.pdf";');
      echo $pdf;
    }
  }

	public function actionGetMemUsage(){
		echo memory_get_usage();
	}
}
