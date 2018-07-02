<?php
/**
 * 路由注册
 *
 * 以下代码为了尽量简单，没有使用路由分组
 * 实际上，使用路由分组可以简化定义
 * 并在一定程度上提高路由匹配的效率
 */

// 写完代码后对着路由表看，能否不看注释就知道这个接口的意义
use think\Route;



//Banner
Route::get('/', 'api/Index/index');
Route::rule('register', 'api/Member/register');
Route::rule('countfee','api/count/lawyerFees');
Route::rule('prisonterm','api/count/prisonTerm');
Route::rule('caseentrust','api/cases/caseEntrust');
Route::rule('aboutus','api/Index/aboutUs');
Route::rule('cooperation','api/Index/cooperation');
Route::rule('caseprocess','api/cases/caseprocess');
Route::rule('memberprocess','api/cases/memberProcess');
Route::rule('trust','api/Index/lawyerTrust');
Route::rule('phone','api/Index/consultingPhone');
Route::rule('online','api/Index/consultingOnline');
Route::rule('region','api/Region/index');
Route::rule('test','api/Index/test');