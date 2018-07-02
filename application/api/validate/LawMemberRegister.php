<?php 
namespace app\api\validate;
class LawMemberRegister extends BaseValidate{
	public $rule=[
		"username"=> 'require|isUerName',
		"lawoffice"=> 'require|isUerName',
		"license"=> 'require|length:17',
		"numbersf"=> 'require|length:17',
		"password"=> 'require|isNotEmpty',
		"phone"=> 'require|isMobile'
	];






}