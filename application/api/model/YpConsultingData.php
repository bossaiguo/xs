<?php
namespace app\api\model;
class YpConsultingData extends BaseModel
{
	protected $name = 'yp_consulting_data';

	public static function getMemberByid($id){
		return Self::getById($id);
	}

	public function lawInfo(){
		return $this->belongsTo('Member','lawid','userid')->field('userid,nickname,logo');
	}


}