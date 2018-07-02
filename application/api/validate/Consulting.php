<?php 
namespace app\api\validate;
class Consulting extends BaseValidate{
	public $rule=[
		"classification"=> 'require|between:6661,6933',
		"address"=> 'require|between:3000,8000',
		"content"=> 'require|max:200'
	];






}