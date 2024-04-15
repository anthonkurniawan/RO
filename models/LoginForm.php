<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user This property is read-only.
 *
 */
class LoginForm extends User
{
  public $rememberMe = true;
  private $_user = false;

  /**
   * @return array the validation rules.
   */
  public function rules()
  {
    $rules = [
      ['rememberMe', 'boolean'],
      ['password', 'validatePass'],  // custom validation
    ];
		return array_merge(parent::rules(), $rules);
  }

  /**
   * Validates the password.
   * This method serves as the inline validation for password.
   *
   * @param string $attribute the attribute currently being validated
   * @param array $params the additional name-value pairs given in the rule
   */
	public function validatePass($attribute, $params)
  {
    if (!$this->hasErrors()) {
      $ldap_enable = \Yii::$app->params['ldap_enable'];
      $user = $this->getUser();
      if(!$user) return $this->addError('uname', 'You are not registered in this system. Please register');

			$authLdap = false;
			if($ldap_enable && $this->uname!='admin'){
				$ldap = $this->ldap;
				$authLdap = $ldap->auth();
				if(!$authLdap)
					return $this->addError($attribute, $ldap->getFirstError('ldap'));
			} 
      
			$authLocal = $user->validatePassword($this->password);

			if($authLocal){
				return;
			}
			elseif($authLdap && $user){
				if($this->uname!='admin'){
					$user->updatePassword($this->password);
          if($user->save()){
            return Yii::$app->cache->delete('user-'.$user->id);
          }
				}
			}
			return $this->addError($attribute, 'Incorrect username or password.');
    }
  }
	
	
  /**
   * Logs in a user using the provided username and password.
   * @return bool whether the user is logged in successfully
   */
  public function login()
  {
    if ($this->validate()) {
      return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
    }
    return false;
  }

  /**
   * Finds user by [[username]]
   *
   * @return User|null
   */
  public function getUser()
  {
    if ($this->_user === false) {
      $this->_user = User::findByUsername($this->uname);
    }
    return $this->_user;
  }
}
