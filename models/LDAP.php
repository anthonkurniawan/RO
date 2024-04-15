<?php
// https://social.technet.microsoft.com/wiki/contents/articles/5392.active-directory-ldap-syntax-filters.aspx
// actionLogin 						: LoginForm->ldap->auth();
// actionLogin_ldap 			: new \app\models\LDAP()->getUser()->format
// actionGetLdapUser			: new \app\models\LDAP()->getUser()->format
// actionRegister   			: RegisterForm->new \app\models\LDAP($this->uname, $this->password)->auth()
// actionRegisterFindUser : new \app\models\LDAP($this->uname, $this->password)->getUserArray($uname);

namespace app\models;

// nslookup win2003.mydns.test.id  (check dc name)

class LDAP extends \yii\base\Model
{
	public $server;
	public $uname;
	public $pass;
	public $dns;
	public $dn;  // base dn
	public $dn_search;
	public $filter;
	public $uname_prefix;	
	private $LDAP_DATA_SHOW = array("cn", "sn", "givenname", "displayname", "mail", "department");
	const LDAP_FILTER_DEFAULT = "(&(objectClass=user)(!(userAccountControl:1.2.840.113556.1.4.803:=2)))"; // user 66050=disable, 66048=enable
	const UNAME_REGEX = '/[\'\"]/';
	
	public function __construct($username = null, $pass = null, $config = []) {  
		$cfg = \Yii::$app->params;
		$this->server = $cfg['ldap_server_ip'];
		$this->dns = $cfg['ldap_server_dns'];
		$this->dn = $this->parseDn($this->dns);
		$this->filter = self::LDAP_FILTER_DEFAULT;
		$this->uname = $username;
		$this->pass = $pass;
		parent::__construct($config);
  }
	
	public function rules() {
    return [
      [['uname', 'pass'], 'required'],
			['uname', 'match', 'not'=>true, 'pattern' => self::UNAME_REGEX],
			// ['uname', 'validateUsername', 'on'=>'register'],  // custom validation (no need already handle in User->RegisterForm validation)
			// ['uname', 'unique', 'message' => 'This username already registered.', 'on'=>['register']],
			// ['search', 'default', 'value' =>'']
    ];
  }
	
	// public function validateUsername($attribute, $params){
		// if($this->hasErrors()) return;
		// $query = "SELECT CASE WHEN EXISTS(SELECT * FROM [users] WHERE uname='$this->uname'";
		// $exist = \Yii::$app->db->createCommand("$query AND status=1) THEN 1 ELSE 0 END")->queryScalar();
		// if($exist) $this->addError($attribute, 'Your username already registered. Please Sign In');
		// // $exist=$this->db->createCommand("$query AND status=0) THEN 1 ELSE 0 END")->queryScalar();
		// // if(!$exist) $this->addError($attribute, 'No permission granted for this username. Please contact your administrator');
	// }
	
	public function attributeLabels() {
    return [
      'uname' => 'Username',
			'pass'=> 'Password',
			// 'search' => "Search"
    ];
  }
	
	public function auth($ret_ldap_res = false) {
		try {
			$con = ldap_connect($this->server);  // 192.168.56.3'
			ldap_set_option($con, LDAP_OPT_PROTOCOL_VERSION, 3);
			$username = preg_match('/@/', $this->uname) ?  $this->uname : $this->uname_prefix."\\".$this->uname;
			$auth = ldap_bind($con, $username, $this->pass);  # method 1

			if($auth) {
				if($ret_ldap_res) return $con;
				else {
					ldap_close($con);
					return $auth;
				}
			}
		}
		catch(\Exception $e){
			$this->setError($e->getMessage());
    }
		return false;
	}
	
	protected function setError($err){
    if(strstr($err, 'credentials')) 
			$err = "Can not find your credential. Please check your username & password";
    elseif (strstr($err, 'ldap')) 
			$err = "Can not connect to LDAP Server";
		else
			$err = $err;
    return $this->addError('ldap', $err);
	}
		
	// 'ldap_search(): Search: No such object'
	public function getUser($con, $search=0) {
		if(!$this->hasErrors()){
			if($search)
				$this->dn_search = "CN=".$search.", CN=users, ".$this->dn; // OU, DC etc..
			else
				$this->dn_search = "CN=Users, ".$this->dn;  // get all users
			$data = null;
			try{
				$rs = ldap_search($con, $this->dn_search, $this->filter, $this->LDAP_DATA_SHOW);
        $data = ldap_get_entries($con, $rs);
				ldap_free_result($rs);
        ldap_close($con);
        return $data;
      }catch(\Exception $e){
        $this->addError('ldap', $e->getMessage());
      }

			if($search && !$data)
				return self::getUserDataSearch($con, $search);
		}
	}
	
	protected function getUserDataSearch($con, $search) {
		$this->dn_search = "CN=Users, ".$this->dn;  // get all users
		$this->filter = "(&(objectClass=user)(cn=$search*))";
		// $this->filter = "(&(objectClass=user)(userprincipalname=$search))";
		// $this->filter = "(&(objectClass=user)(mail=test@test.com))";
		try{
			$rs = ldap_search($con, $this->dn_search, $this->filter, $this->LDAP_DATA_SHOW);
      $data = ldap_get_entries($con, $rs);
      ldap_close($con);
			$this->clearErrors();
      return $data;
    }catch(\Exception $e){
      $this->addError('ldap', preg_replace('/[\'\"]/',"\\'", $e->getMessage()));
    }
	}
	
	public function getUserArray($search=0){
		$con = $this->auth(); 
		if($con){
			$data = $this->getUser($search);
			if($data){
				return $this->formatData($data);
			}
			return $con;
		}
	}
	
	public function formatData($data) {
		if(!$data || $this->hasErrors()) return;
		$users = array();
		foreach($data as $v) {
			if(!isset($v['cn'])) continue;
			$uname = isset($v['cn'][0]) ? $v['cn'][0] : "";
			$dname = isset($v['displayname'][0]) ? $v['displayname'][0] : "";
			$fname = isset($v['givenname'][0]) ? $v['givenname'][0] : "";
			$lname = isset($v['sn'][0]) ? $v['sn'][0] : "";
			$email = isset($v['mail'][0]) ? $v['mail'][0] : "";
			$dept = isset($v['department'][0]) ? $v['department'][0] : "";
			
			$users[$uname] = array(
				'uname'     =>$uname,
				'dname'     =>$dname,
				'fname' =>$fname,
				'lname'  =>$lname,
				'email'     =>$email,
				'dept'      =>$dept
			);
		}
		return $users;
	}
	
	protected function parseDn($dn){
		$parts = explode('.', $dn);
		$dn="";
		$this->uname_prefix = $parts[0];
		for($i=0; $i < count($parts); $i++){
			$dn .= "DC=$parts[$i]" . ($i < count($parts)-1 ? ", ":"");
		}
		return $dn;
	}
	
	public function getPrefix(){
		// $this->parseDn();
		return $this->uname_prefix;
	}

}
