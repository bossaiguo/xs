<?php 
namespace app\api\model;
class Yp_company extends BaseModel{
	protected static function init()
    {
        // 在插入yp_company时，要先上传图片
      	Self::event('before_insert',function($data){
            $folder='./uploads';
            if($_FILES){
                if(request()->file('licenseUrl')){
                    $licenseUrlFile = request()->file('licenseUrl');
                    $licenseUrl=array();
                    if (is_array($licenseUrlFile)) {
                        foreach ($licenseUrlFile as $val) {
                          $info=$val->move($folder);
                          if($info){
                            $licenseUrl[]= $folder.'/'.$info->getFilename();
                          }
                        }
                        $data['licenseUrl']=join(',',$licenseUrl);
                    }else{
                        $info=$licenseUrlFile->move($folder);
                        $data['licenseUrl'] = $folder.'/'.$info->getFilename();
                    }
                    
                }
                if(request()->file('authidUrl')){
                    $authidUrlFile = request()->file('authidUrl');
                    $authidUrl=array();
                    if(is_array($authidUrlFile)){
                        foreach ($authidUrlFile as $val) {
                          $info=$val->move($folder);
                          if($info){
                            $authidUrl[]= $folder.'/'.$info->getFilename();
                          }
                        }
                        $data['authidUrl']=join(',',$authidUrl);
                    }else{
                        $info=$authidUrlFile->move($folder);
                        $data['licenseUrl'] = $folder.'/'.$info->getFilename();
                    }
                    
                }
            }
      	});
    }













}