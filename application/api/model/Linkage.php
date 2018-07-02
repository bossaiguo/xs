<?php
namespace app\api\model;
class Linkage extends BaseModel
{
	public static function getLinkageVal($keyid,$linkageid,$separat="-"){
		static $linkageVal = '';
		// $linkageData=Self::get(['keyid' => $keyid])->field('linkageid,parentid,name');
		$linkageData=Self::get(function($query) use ($keyid,$linkageid){
			 $query->where('keyid', $keyid)->where('linkageid',$linkageid)->field('linkageid,parentid,name');
		})->toArray();
		if( $linkageVal == ''){
			$linkageVal = $linkageData['name'];
		}else{
			$linkageVal = $linkageVal .$separat.$linkageData['name'];
		}
		if($linkageData['parentid'] != 0){
			Self::getLinkageVal($keyid,$linkageData['parentid'],$separat="-");
		}
		return $linkageVal;
	}


}