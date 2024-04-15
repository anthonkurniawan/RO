<?php
// https://social.technet.microsoft.com/wiki/contents/articles/5392.active-directory-ldap-syntax-filters.aspx
namespace app\models;

// nslookup win2003.mydns.test.id  (check dc name)

class LDAP_Tool extends LDAP
{
	public $search;
	public $filter_opt;
	const FILTER_ALL = "(objectClass=*)";
	const LDAP_FILTER_2 = "(&(objectClass=user)(userAccountControl=66048))"; // user 66050=disable, 66048=enable
	const FILTER_ENABLE = "(&(objectClass=user)(!(userAccountControl:1.2.840.113556.1.4.803:=2)))"; // show all enable users
	const FILTER_DISABLE = "(&(objectClass=user)(userAccountControl:1.2.840.113556.1.4.803:=2))";
	const FILTER_CONTACT = "(objectClass=contact)";
	const FILTER_COMPUTER = "(objectCategory=computer)";
	const FILTER_DOMAIN = "(objectCategory=domain)";
	const FILTER_BUILTIN_DOMAIN = "(objectCategory=builtinDomain)";
	const FILTER_CONTAINER = "(objectCategory=container)";
	const FILTER_PRINCIPAL = "(servicePrincipalName=*)";
	const FILTER_ALL_DC = "(primaryGroupID=516)"; // All Domain Controllers
	
	public static function getList()
  {
		return [
			self::FILTER_ALL, 
			self::LDAP_FILTER_2, 
			self::FILTER_ENABLE, 
			self::FILTER_DISABLE,
			self::FILTER_CONTACT,
			self::FILTER_COMPUTER,
			self::FILTER_DOMAIN,
			self::FILTER_BUILTIN_DOMAIN,
			self::FILTER_CONTAINER,
			self::FILTER_PRINCIPAL,
			self::FILTER_ALL_DC
		];
  }
	
	public function rules() {
    $rules =  [
			[['filter','dns'], 'required'],
			[['search'], 'trim'],
			['filter_opt', 'integer']
			// [['filter'], 'required', 'on'=>['check_ldap']],
			// ['filter', 'default', 'value' =>self::LDAP_FILTER_2]
    ];
		return array_merge(parent::rules(), $rules);
  }
	
	public function auth($ret_ldap_res = false) {
    // $prefix = $this->server."\\";
		try {
			$con = ldap_connect($this->server);  // 192.168.56.3'
			ldap_set_option($con, LDAP_OPT_PROTOCOL_VERSION, 3);   // its works even not set
			$username = preg_match('/@/', $this->uname) ?  $this->uname : $this->uname_prefix."\\".$this->uname;
			$auth = ldap_bind($con, $username, $this->pass);  # method 1
			// $auth = ldap_bind($con, $this->uname."@".\Yii::$app->params['ldap_server_dns'], $this->pass); # method 2

			if($auth) {
				if($ret_ldap_res) return $con;
				else {
					ldap_close($con);
					return $auth;
				}
			}
		}
		catch(\Exception $e){
			// '2-ldap_bind(): Unable to bind to server: Can\\\'t contact LDAP server'
			// 'ldap_bind(): Unable to bind to server: Invalid credentials'
			$this->addError('ldap', $e->getCode() ."-". preg_replace('/[\'\"]/',"\\'", $e->getMessage()));
    } 
		catch(\Throwable $e) {
      $this->addError('ldap', preg_replace('/[\'\"]/',"\\'", $e->getMessage()));
    }
		return false;
	}
	
	// 'ldap_search(): Search: No such object'
	public function getData() {
		$con = $this->auth(true);
		$this->dn = $this->parseDn($this->dns);
		if(!$this->hasErrors()){
			if($this->search)
				$this->dn_search = "CN=".$this->search.", CN=users, ".$this->dn; // OU, DC etc..
			else
				$this->dn_search = "CN=Users, ".$this->dn;  // get all users
			// $this->dn_search = $this->dn; // get all object user, group, computer, etc
			// $this->dn_search = "CN=test TOST, CN=users, DC=mydns, DC=test, DC=id";
			// $this->dn_search = "SN=test, CN=users, DC=mydns, DC=test, DC=id";
			// $this->dn_search = "CN=Person,CN=Schema,CN=Configuration,DC=mydns,DC=test,DC=id";
			// $this->dn_search = 'CN=Administrators,CN=Builtin,DC=mydns,DC=test,DC=id';
			// $this->dn_search = "sn=test, CN=users, DC=mydns, DC=test, DC=id";
			// echo "DN: $this->dn_search<br>"; die();
			$data = null;
			try{
				// $rs = ldap_search($con, $this->dn_search, $this->filter, self::LDAP_DATA_SHOW);
				$rs = ldap_search($con, $this->dn_search, $this->filter);
        $data = ldap_get_entries($con, $rs);
        ldap_close($con);
      }catch(\Exception $e){
        $this->addError('ldap', preg_replace('/[\'\"]/',"\\'", $e->getMessage()));
      }

			if($data)
				return $data;
			else
				return self::getUserDataSearch($con, $this->search);
		}
	}
	
	protected function getUserDataSearch($con, $search) {
		$this->dn_search = "CN=Users, ".$this->dn;  // get all users
		$this->filter = "(&(objectClass=user)(cn=$search*))";
		// $this->filter = "(&(objectClass=user)(userprincipalname=$search))";
		// $this->filter = "(&(objectClass=user)(mail=test@test.com))";
		try{
			$rs = ldap_search($con, $this->dn_search, $this->filter);
       $data = ldap_get_entries($con, $rs);
       ldap_close($con);
			 $this->clearErrors();
       return $data;
     }catch(\Exception $e){
       $this->addError('ldap', preg_replace('/[\'\"]/',"\\'", $e->getMessage()));
     }
	}
	
}
