<?php 
namespace app\api\controller;
use app\api\model\Member as MemberModel;
use app\api\model\Yp_company as Yp_companyModel;
use app\api\validate\LawMemberRegister;
use app\api\validate\CommonMemberRegister;
use app\lib\exception\RegisterException;
use app\api\validate\LoginValidate;
use think\Cookie;
class Member extends BaseController
{
	public function _initialize(){
		$this->_init_phpsso();
	}
    
	public function register(){

		return view();
	}

	/**
	 * 注册律师用户
	 * @param 
	 * @return 
	*/
	public function registerLaw(){
		// $validate = new LawMemberRegister();
		// $validate->goCheck();
		// $allData = $validate->getDataByRule(input('post.'));
		$allData = input('post.');
 		$memberModel = new MemberModel;
		$memberModel->username = $allData['username'];
		$memberModel->nickname = $allData['username'];
		$memberModel->mobile = $allData['phone'];
		$memberModel->password = $allData['password'];
		$memberModel->email = getRandomEamil();
		$memberModel->regip = ip();
		$memberModel->encrypt = create_randomstr(6);
		$memberModel->phpssouid = $this->registerPhpssouid($memberModel->username,$memberModel->password,$memberModel->email,$memberModel->regip,$memberModel->encrypt);
		$memberModel->password = password($memberModel->password, $memberModel->encrypt);
		$memberModel->selectid = 1;

		//需要注册两张表，注册lawin_yp_company和member表 为了和法律之窗同步。
		if($memberModel->save()){
			$yp_companyModel = new Yp_companyModel;
			$yp_companyModel->lawyername = $allData['username'];
			$yp_companyModel->userid = $memberModel->userid;
			$yp_companyModel->lawoffice = $allData['lawoffice'];
			$yp_companyModel->license = $allData['license'];
			$yp_companyModel->telephone = $allData['phone'];
			$yp_companyModel->phpssouid = $memberModel->phpssouid;
			if($yp_companyModel->save()){
				$this->success('注册成功',url('index/index'));
			}else{
				$this->error('注册失败！');
			}
		}
		
	}

	/**
	 * 注册普通用户
	 * @param 
	 * @return 
	*/
	public function registerMember(){
		$validate = new CommonMemberRegister();
		$validate->goCheck();
		//根据规则取字段是很有必要的，防止恶意更新非客户端字段
		$data = $validate->getDataByRule(input('post.'));
		// 由于phpcms 注册需要email，并且必不可少。
		$memberModel = new MemberModel;
		$memberModel->username = $data['username'];
		$memberModel->nickname = $data['username'];
		$memberModel->mobile = $data['mobile'];
		$memberModel->password = $data['password'];
		$memberModel->email = getRandomEamil();
		$memberModel->regip = ip();
		$memberModel->encrypt = create_randomstr(6);
		$memberModel->phpssouid = $this->registerPhpssouid($memberModel->username,$memberModel->password,$memberModel->email,$memberModel->regip,$memberModel->encrypt);
		$memberModel->password = password($memberModel->password, $memberModel->encrypt);
		$memberModel->selectid = 2;
		if($memberModel->save()){
			$this->success('注册成功','index/index');
		}else{
			$this->error('注册失败');
		}
	}

	// 得到phpssouid
	private function registerPhpssouid($username,$password,$email,$regip,$encrypt){
		// 检查用户名时已经初始化了
		$phpssouid=$this->client->ps_member_register($username,$password,$email,$regip,$encrypt);
		if($phpssouid>0){
			return $phpssouid;
		}else{
			throw new RegisterException();
		}
	}

	/**
	 * 检查用户是否可以注册
	 * @param string $username
	 * @return int {-4：用户名禁止注册;-1:用户名已经存在 ;1:成功}
	*/

	public function checkName(){
		$username = isset($_POST['username']) && trim($_POST['username']) ? trim($_POST['username']) : exit(0);
		$status = $this->client->ps_checkname($username);
		if($status == -4 || $status == -1) {
			exit('0');
		} else {
			exit('1');
		}
	}

	/**
	 * 用户登录功能
	 * @param string $username， string $password
	 * $status -1:用户名错误 -2：密码错误 -3 密码位数不对
	 * @return string{'success':登录成功；'error'：登录失败}
	*/
	public function ajaxLogin(){
		$validate = new LoginValidate();
		$validate->goCheck();
		//根据规则取字段是很有必要的，防止恶意更新非客户端字段
		$data = $validate->getDataByRule(input('post.'));
		$status=$this->client->ps_member_login($data['username'], $data['password']);
		if($status == '-1' || $status == '-2' || $status == '-5') exit('error');

		$memberinfo = unserialize($status);
		$expire = 3600 * 4;
		Cookie::set('username',$memberinfo['username'],$expire);
		Cookie::set('phpssouid',$memberinfo['uid'],$expire);
		exit('success');	
	}









}
