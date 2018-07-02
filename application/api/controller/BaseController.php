<?php


namespace app\api\controller;
use think\Controller;
use app\lib\phpssouid\Client;
class BaseController extends Controller
{
    /**
     * 初始化phpsso
     * about phpsso, include client and client configure
     * @return string phpsso_api_url phpsso地址
     */
    protected function _init_phpsso() {
    	$phpsso_api_url = config('PHPSSO_API_URL');
    	$phpsso_auth_key = config('PHPSSO_AUTH_KEY');
    	$this->client = new Client($phpsso_api_url, $phpsso_auth_key);
    	return $phpsso_api_url;
    }
    /**
     * 判断是否登录
     * @return 登录了 返回phpssouid 否则 false
     */
    protected function is_login(){
        $phpssouid = cookie('phpssouid');
        if($phpssouid){
            return $phpssouid;
        }else{
            return false;
        }
    }
}