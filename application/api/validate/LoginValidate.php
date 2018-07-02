<?php 
namespace app\api\validate;
class LoginValidate extends BaseValidate{
	public $rule=[
		"username"=> 'require|isUerName',
		"password"=> 'require|isNotEmpty'
	];

}