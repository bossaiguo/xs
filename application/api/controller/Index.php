<?php 
namespace app\api\controller;
use app\api\model\Member;
use app\api\validate\PhpssouidMustBePositiveInt;
use think\Db;
use app\api\model\Linkage as LinkageModel;
use app\api\service\Consulting as ConsultingService;
use app\api\validate\Consulting as ConsultingValidate;
class Index extends BaseController
{
	/*首页*/
	public function index(){
	 	// $consultingData = ConsultingService::getConsultingData();
	 	// $consultingData = Member::with('detail')->where("userid=2")->find()->toArray();
	 	$consultingData = LinkageModel::getLinkageVal(3360,4142,$separat="-");
	 	echo "<pre>";
	 	print_r($consultingData);
	 	exit;
	    return view();
	}
	/*关于我们*/
	public function aboutUs(){
		return view();
	}
	/*合作用户*/
	public function cooperation(){
		/*由于case模型发生错误，所以只能写在controller里面*/
		$result = Db::table('lawin_case')->where('status=99')->where('exchange=0')->where('managelaw>0')->order('id desc')->limit(0,10)->field('phpssouid,linkage,classification,managelaw,inputtime')->select()->toArray();

		$classificationKeyid = config('Linkage_classification_keyid');
		$linkageKeyid = config('Linkage_area_keyid');
		foreach ($result as &$val) {
			$val['username'] = Member::getNameByPhpssouid($val['phpssouid']);
			$val['lawyername'] = Member::getNameByUserid($val['managelaw']);;
			$val['linkage'] = Linkage :: getLinkageVal($linkageKeyid,$val['linkage']);
			$val['classification'] = Linkage :: getLinkageVal($classificationKeyid,$val['classification']);
			$val['inputtime'] = date("Y-m-d");
		}
		$this->assign('result',$result); 
		return view();
	}
	/*真实可靠*/
	public function lawyerTrust(){
		return view();
	}

	/*我要咨询 -- 电话咨询*/
	public function consultingPhone(){
		return view();
	}

	/* 我要咨询 -- 在线咨询*/
	public function consultingOnline(){
		if(!empty(input('post.'))){
			$validate = new ConsultingValidate();
			$validate->goCheck();
			if($this->is_login()){
				//根据规则取字段是很有必要的，防止恶意更新非客户端字段
				$data = $validate->getDataByRule(input('post.'));
				$data['inputtime'] = time();
				/*此地方存phpssouid更为合理*/
				$memberInfo = Member::getMemberInfo();
				$data['userid'] = $memberInfo['userid'];
				$result=Yp_consulting::create($data);
				$this->redirect('api/Index/consultingOnline');
			}else{
				$this->error('登录账户才能咨询哦', 'Index/consultingOnline');
			}
		}else{
			return view();
		}	
	} 
	/*业务范围*/
	public function region(){
		return view();
	}
	public function test(){
		
	}
	

}
?>