<?php 
namespace app\api\model;
use think\Cookie;
class Member extends BaseModel
{
	public function detail(){
		return $this->hasOne('MemberDetail','userid','userid')->field('userid,region');
	}
	public static function getMemberInfo(){
		$phpssouid = Cookie::get('phpssouid');
		return self::getByPhpssouid($phpssouid);
	}
	/*根据phpssouid得到用户nickname*/
	public static function getNameByPhpssouid($phpssouid){
		$memberinfo=self::getByPhpssouid($phpssouid);
		return $memberinfo['nickname'];
	}
	/*根据userid得到用户的nickname*/
	public static function getNameByUserid($userid){
		$memberinfo=self::getByUserid($userid);
		return $memberinfo['nickname'];
	}









}
