<?php 
namespace app\api\validate;
class CommonMemberRegister extends BaseValidate{
	public $rule=[
		"username"=> 'require|isUerName',
		"password"=> 'require|isNotEmpty',
		"mobile"=> 'require|isMobile'
	];






}