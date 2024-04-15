<?php
namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $uname
 * @property string|null $fullname
 * @property string|null $email
 * @property int $dept_id
 * @property string|null $signature
 * @property int $status
 * @property int $role
 * @property string|null $priv
 * @property int $created_at
 * @property int $updated_at
 * @property string $auth_key
 * @property string $password_hash
 * @property string $access_token
 * @property string|null $password_reset_token
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
  public $password;
  public $newPassword;
  public $dept_name;

  const STATUS_ACTIVE = 1;
  const STATUS_INACTIVE = 0;
  const ROLE_SYSADMIN = 1;
  const ROLE_ADMIN = 2;
  const ROLE_INITIATOR = 3;
	const UNAME_REGEX = '/\\\\/';
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'users';
  }

  /**
   * @inheritdoc
   */
  public function behaviors()
  {
    return [
      TimestampBehavior::className(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['uname', 'email', 'dept_id', 'role'], 'required', 'on'=>['register', 'create', 'update']],
			[['uname', 'password'], 'required', 'on'=>['login', 'register']],
			// [['password'], 'required', 'on'=>['pre-register']],
			// [['password'], 'required', 'on'=>['register', 'update']],
      ['uname', 'string', 'min' => 2],
			[['uname', 'fullname', 'email', 'priv'], 'string', 'max' => 255],
			[['uname','email','fullname','password'], 'trim'],
			[['uname'], 'match', 'not'=>true, 'pattern' => self::UNAME_REGEX],
			['uname', 'unique', 'message' => 'This username already registered.', 'on'=>['create', 'register']],
      //['uname', 'exist', 'message' => 'No permission granted for this uname. Please contact your administrator', 'on'=>'register'],
      // [['signature', 'auth_key'], 'string', 'max' => 50],
			['password', 'string', 'min' => 4],
      ['email', 'email'],
			['email', 'unique', 'message' => 'This email address already registered.'],
      ['role', 'default', 'value' => self::ROLE_INITIATOR],
      ['role', 'in', 'range' => [self::ROLE_SYSADMIN, self::ROLE_ADMIN, self::ROLE_INITIATOR]],
      ['status', 'default', 'value' => self::STATUS_ACTIVE],
      ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],
			['email', 'required', 'on'=>['register','recovery']],
      'passwordRequired' => [['newPassword', 'passwordConfirm'], 'required', 'on' => ['reset-password']],
			//[['uname', 'email', 'dept_id', 'role', 'created_at', 'updated_at', 'auth_key', 'password_hash', 'access_token'], 'required'],
      //[['dept_id', 'role', 'created_at', 'updated_at', 'last_loged'], 'integer'],
      //[['uname', 'fullname', 'email', 'spv', 'priv', 'password_hash', 'access_token', 'password_reset_token'], 'string', 'max' => 255],
    ];
  }

  public function scenarios()
  {
    return array_merge(parent::scenarios(), [
      'reset-password' => ['newPassword'],
    ]);
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'uname' => 'Username',
      'fullname' => 'Fullname',
      'email' => 'Email',
      'dept_id' => 'Departement',
      'signature' => 'Signature',
      'status' => 'Status',
      'role' => 'Role',
      'priv' => 'Priv',
      'created_at' => 'Created',
      'updated_at' => 'Updated',
      'last_loged' => 'Last Login',
      'auth_key' => 'Auth Key',
      'password_hash' => 'Password Hash',
      'access_token' => 'Access Token',
      'password_reset_token' => 'Password Reset Token',
      'dept_name' => 'Departement',
      'newPassword' =>'newPassword'
    ];
  }

  public function beforeSave($insert)
  {
    if (parent::beforeSave($insert)) {
      if ($this->scenario == 'reset-password') {
        $this->updatePassword($this->newPassword);
      }
      if(!$this->isNewRecord){
        $this->touch('updated_at');
      }
      return true;
    } else return false;  // IS UPDATE
  }
	

  # interface IdentityInterface ------------------
  /**
   * @inheritdoc
   */
  public static function findIdentity($id)
  {
    return static::findUser($id);
  }

  public static function findUser($id){
    $user = Yii::$app->cache->getOrSet('user-'.$id, function() use($id) {
      return  static::find()
      ->select(['users.*', 'dept.label as dept_name'])
      ->where('users.id=:id')->addParams([':id'=>$id])
      ->join('LEFT JOIN', 'dept', 'users.dept_id = dept.id')->one();
    });
    return $user;
  }

  /**
   * Finds user by username
   *
   * @param string $username
   * @return static|null
   */
  public static function findByUsername($username)
  {
    return static::findOne(['uname'=>$username, 'status'=>self::STATUS_ACTIVE]);//return static::find()->where(['username' => $username,'status' => static::STATUS_ACTIVE])->andWhere(['!=', 'password_hash', NULL])->one();
  }
	
	public static function findByEmail($email)
  {
    return static::findOne(['email'=>$email, 'blocked_at'=>NULL]); 
  }

  /**
   * Finds user by password reset token
   *
   * @param string $token password reset token
   * @return static|null
   */
  public static function findByPasswordResetToken($token)
  {
    if (!static::isPasswordResetTokenValid($token)) {
      return null;
    }

    return static::findOne([
      'password_reset_token' => $token,
      'status' => self::STATUS_ACTIVE,
    ]);
  }

  /**
   * @inheritdoc
   * $type the type of the token. The value of this parameter depends on the implementation.
   * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`
   */
  public static function findIdentityByAccessToken($token, $type = null)
  {
    return static::findOne(['access_token' => $token]);
  }
	
	public function getLdap($search = null){
		return new \app\models\LDAP($this->uname, $this->password, $search);
	}

  /**
   * @inheritdoc
   */
  public function getId()
  {
    return $this->getPrimaryKey();
  }

  /**
   * This is required if [[User::enableAutoLogin]] is enabled.
   */
  public function getAuthKey()
  {
    return $this->auth_key;
  }

  /**
   * This is required if [[User::enableAutoLogin]] is enabled.
   */
  public function validateAuthKey($authKey)
  {
    return $this->getAuthKey() === $authKey;
  }

  /**
   * Finds out if password reset token is valid
   *
   * @param string $token password reset token
   * @return boolean
   */
  public static function isPasswordResetTokenValid($token)
  {
    if (empty($token)) {
      return false;
    }
    $expire = Yii::$app->params['users.passwordResetTokenExpire'];
    $parts = explode('_', $token);
    $timestamp = (int) end($parts);
    return $timestamp + $expire >= time();
  }

  /**
   * Validates password
   *
   * @param string $password password to validate
   * @return boolean if password provided is valid for current user
   */
  public function validatePassword($password)
  {
    return Yii::$app->security->validatePassword($password, $this->password_hash);
  }

  public function updatePassword($password){
    $this->password = $password;
    $this->setPassword($this->password);
    $this->generateAuthKey();
    $this->generateAccessToken();
  }

  /**
   * Generates password hash from password and sets it to the model
   *
   * @param string $password
   */
  public function setPassword($password)
  {
    $this->password_hash = Yii::$app->security->generatePasswordHash($password);
  }

  /**
   * Generates "remember me" authentication key
   */
  public function generateAuthKey()
  {
    $this->auth_key = Yii::$app->security->generateRandomString();
  }

  /**
   * Generates new password reset token
   */
  public function generatePasswordResetToken()
  {
    $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
  }

  public function generateAccessToken()
  {
    $this->access_token = Yii::$app->security->generateRandomString() . '_' . $this->uname;;
  }

  /**
   * Removes password reset token
   */
  public function removePasswordResetToken()
  {
    $this->password_reset_token = null;
  }

  public function getIsAdmin()
  {
    $user = Yii::$app->user;
    return $user->identity && ($user->identity->role == self::ROLE_ADMIN || $user->identity->role == self::ROLE_SYSADMIN);
  }

  /**
   * @return bool Whether the user is blocked or not.
   */
	public function getIsSysAdmin()
  {
    $user = Yii::$app->user;
    return $user->identity && $user->identity->role == self::ROLE_SYSADMIN;
  }

  public function getDept()
  {
    return $this->hasOne(Dept::className(), ['id' => 'dept_id'])->cache(600);
  }

  public function getDeptByName()
  {
    return $this->hasOne(Dept::className(), ['label' => 'dept']);
  }

  public function getStatusText($status)
  {
    return $this->getStatusList(true)[$status];
  }

  public function getRoleText()
  {
    $list = $this->getRoleList();
    if(isset($list[$this->role])) return $list[$this->role];
  }

  public static function getStatusList()
  {
    return [self::STATUS_ACTIVE => 'Active', self::STATUS_INACTIVE => 'Disabled'];
  }

  public static function getRoleList()
  {
    return [self::ROLE_INITIATOR => 'Initiator', self::ROLE_ADMIN => 'Administrator'];
  }

  /**
   * Gets query for [[Comments]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getComments()
  {
    return $this->hasMany(Comment::className(), ['user_id' => 'id']);
  }

  /**
   * Gets query for [[Logs]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getLogs()
  {
    return $this->hasMany(Log::className(), ['userid' => 'id']);
  }

  /**
   * Gets query for [[Orders]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getOrders()
  {
    return $this->hasMany(Orders::className(), ['initiator_id' => 'id']);
  }

  /**
   * Gets query for [[Orders0]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getOrders0()
  {
    return $this->hasMany(Orders::className(), ['assign_to' => 'id']);
  }

	// public function updateLastLogin()
  // {
    // $this->updateAttributes(['last_login' => time()]);
  // }
	
  // public function findUserByLdap(){
		// $username = $this->uname;
		// // \yii\helpers\VarDumper::dump($this, 10, true);
		
    // $dn = "cn=$username,ou=People,dc=example,dc=com";
    // $ldap = $this->getLdap();
		// \yii\helpers\VarDumper::dump($ldap, 10, true);
		// die();
    
		// if($ldap){
      // $rs = ldap_search($ldap, $dn,  "(cn=*)");  
			// \yii\helpers\VarDumper::dump($rs, 10, true);
    // }
  // }

}
