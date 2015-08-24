<?php 

namespace app\models;

use Yii;
use yii\base\Model;

class RegisterForm extends Model
{
	public $username;
	public $password;
	public $email;

	

	
	/**
	* 
	* @return array
	*/
	public function attributeLabels()
	{
		return [
			'username'    => '用户名',
			'password'    => '密码',
			'email'       => '电子邮件',
			];
	}
	
	public function rules()
	{
		return [
			['username', 'filter', 'filter' => 'trim'],
			['username', 'required'],
			['username', 'match', 'pattern' => '/^[a-z]\w*$/i', 'message' => '{attribute}只能字母或者数字'],
			['username', 'unique', 'targetClass' => '\app\models\User', 'message' => '{attribute}已经被使用'],
			['username', 'string', 'min' => 2, 'max' => 255],
			
			['email', 'filter', 'filter' => 'trim'],
			['email', 'required'],
			['email', 'email'],
			['email', 'unique', 'targetClass' => '\app\models\User', 'message' => '{attribute}已经被使用'],
			
			['password','required'],
			['password', 'string', 'min' => 6, 'message' => '密码最短6'],
		];
	}
	
	public function save(){
		if($this->validate()){
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->save();
			return $user;
		}
		return null;
	}
}