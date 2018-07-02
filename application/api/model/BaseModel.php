<?php
namespace app\api\model;
use think\Model;


class BaseModel extends Model
{
	/**
	 * 生成上传图片文件夹
	 * @param 
	 * @return 
	*/
	protected static function makeUploadFolder(){
		$filepath = date('Y/md/');
		$folder = './uploads/'.$filepath;
		if (!file_exists($folder)) {
		      //检查是否有该文件夹，如果没有就创建，并给予最高权限
		      mkdir($folder, 0777,true);
		  }
		return $folder;
	}

}