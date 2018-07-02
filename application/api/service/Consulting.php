<?php 
namespace app\api\service;
use app\api\model\YpConsulting as YpConsultingModel;
class Consulting{

	public static function getConsultingData(){
		$consultingData=YpConsultingModel::getConsultingData();
		$result =Self::handleConsultingData($consultingData);
		return $result;
	}

	/**首页中咨询轮播
     * 计算每个咨询的评论人数
     * @return array $result数组
     */
    private static function handleConsultingData($consultingData){
    	foreach ($consultingData as &$val) {
    		$consultingLaw = $val['consulting_data'];
    		$mobile = $val['member']['mobile'];
    		$val['member']['mobile'] = substr($mobile,0,3).'****'.substr($mobile,-4);
    		$val['countLaw'] = count($consultingLaw);
    		$val['lawRepresent'] = $val['consulting_data'][0];

    	}
    	return $consultingData;
    }

}
?>