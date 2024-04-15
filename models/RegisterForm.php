<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * RegisterForm is the model behind the register form.
 * @property-read User|null $user This property is read-only.
 *
 */

class RegisterForm extends User
{

  public function rules()
  {
    $rules = [
      ['password', 'validateLdap']
    ];
    return array_merge(parent::rules(), $rules);
  }
	
	public function validateLdap($attribute, $params)
  {
		if($this->hasErrors()) return;
		if(\Yii::$app->params['ldap_enable']){
			$ldap = new \app\models\LDAP($this->uname, $this->password);
			if(!$ldap->auth()){
				$this->addError($attribute, $ldap->getFirstError('ldap'));
			}
		}
	}
}
