<?php 
namespace app\api\validate;

class Cases extends BaseValidate
{
	protected $rule = [
        'title' => 'require|isNotEmpty',
        'content' => 'require|max:200',
        'classification' => 'require|between:6661,6933',
        'accountMoney' => 'require|between:6767,6772',
        'entrustcost' => 'require| isNotEmpty',
        'linkage' => 'require|between:3000,8000'
    ];
}