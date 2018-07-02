<?php 
namespace app\api\controller;
use app\api\validate\Cases as CaseValidate;
use app\api\model\Member as MemberModel;
// use app\api\controller\Linkage;
use think\Db;
// use app\api\model\Case as CaseModel;
class Cases extends BaseController{
	/*案件委托*/
	public function caseEntrust(){
		$result = Db::table('lawin_case')->where('exchange=0')->where('casestatus=0')->order('id desc')->limit(0,10)->field('id,title,accountMoney,phone,linkage')->select()->toArray();
		$linkageKeyid = config('Linkage_area_keyid');
		$accountMoneyKeyid = config('Linkage_accountMoney_keyid');
		foreach ($result as &$val) {
			// $val['accountMoney'] = Linkage :: getLinkageVal($accountMoneyKeyid,$val['accountMoney']);
			// $val['linkage'] = Linkage :: getLinkageVal($linkageKeyid,$val['linkage']);
			$val['phone'] = hidePhone($val['phone']);
			$val['title'] = mb_substr( $val['title'], 0, 5, 'utf-8' ).'...';
		}
		$this->assign('result',$result); 
		return view();
	}

	public function submitCase(){
		$validate = new CaseValidate();
		$validate->goCheck();
		//根据规则取字段是很有必要的，防止恶意更新非客户端字段
		$data = $validate->getDataByRule(input('post.'));

		$memberInfo = MemberModel::getMemberInfo();

	}
	/*案件进程首页*/
	public function caseProcess(){
		return view();
	}

	/*用户案件进程*/
	public function memberProcess(){
		return view();
	}









}