<?php
namespace app\api\model;
class YpConsulting extends BaseModel
{
	protected $name = 'yp_consulting';

	public function consultingData(){
		return $this->hasMany('YpConsultingData','consulting_id','id')->field('id,lawid,consulting_id,consulting_con');
	}
	
	public function member(){
		return $this->belongsTo('Member','userid','userid')->field('mobile,nickname,userid');
	}

	/*首页中的咨询信息轮播*/
	public static function getConsultingData(){
		// return Self::with(['member','member.detail'])->where('status=99')->where('reply=1')->where('id = 17')->limit(10)->select()->toArray();
		 return Self::with(['member','member.detail','consultingData','consultingData.lawInfo'])->select(function($query){
    				$query->where('status=99')->where('reply=1')->order('id desc')->limit(10)->field("id,content,userid");
				})->toArray();
	}
}