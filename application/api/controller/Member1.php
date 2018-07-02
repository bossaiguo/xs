<?php 
namespace app\api\controller;
use app\api\model\Member as MemberModel;
use app\api\model\Yp_company as Yp_companyModel;
use app\api\validate\LawMemberRegister;
use app\api\validate\CommonMemberRegister;
use app\lib\exception\RegisterException;
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
		$validate = new LawMemberRegister();
		$validate->goCheck();
		$allData = $validate->getDataByRule(input('post.'));
		$data['email']= getRandomEamil();
		$data['regip']=ip();
		$data['encrypt']=create_randomstr(6);
		$password=password($allData['password'], $data['encrypt']);
		$data['password']=$password;
		$phpssouid=$this->registerPhpssouid($data);
		$data['phpssouid']=$phpssouid;
		//需要注册两张表，注册lawin_yp_company和member表 为了和法律之窗同步。
		if(MemberModel::create($data)){
			
		}
		if(YP_companyModel::create($data)){
			$this->success('注册成功',url('index/index'));
		}else{
			$this->error('注册失败');
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
		$data['email']= getRandomEamil();
		$data['regip']=ip();
		$data['encrypt']=create_randomstr(6);
		$phpssouid=$this->registerPhpssouid($data);
		$data['phpssouid']=$phpssouid;
		$password=password($data['password'], $data['encrypt']);
		$data['password']=$password;
		$data['nickname']=$data['username'];
		$data['selectid']=2;
		if(MemberModel::create($data)){
			$this->success('注册成功','index/index');
		}else{
			$this->error('注册失败');
		}
	}

	// 得到phpssouid
	private function registerPhpssouid($data){
		$password=$data['password'];
		$username=$data['username'];
		$email=$data['email'];
		$regip=$data['regip'];
		$encrypt=$data['encrypt'];
		var_dump($password);
		exit;
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











}
