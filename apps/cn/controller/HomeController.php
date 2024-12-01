<?php
namespace app\cn\controller; 
use think\Db;
use think\Controller;
use think\Session;
class HomeController extends BaseController{	
	public function _initialize(){
		parent::_initialize();
	}
    public function index(){  
		$config = Db::table('tbl_config')->where(['id'=>1])->field('title,is_code')->find();
		
		$this->assign('uinfo',Db::table('tbl_user')->where(['id'=>session('userid')])->field('username,is_all')->find());
		$this->assign('is_code',$config['is_code']);
		$this->assign('title',$config['title']);
	 	return view();
    }
	public function login(){ 
	    $config = Db::table('tbl_config')->where(['id'=>1])->field('title,is_reg')->find();
		if(!empty($_POST)){
			$data = input('post.');
			$validate = new \think\Validate([
				['account', 'require|alphaDash', '用户名不能为空|用户名格式只能是字母、数字、——或_'],
				['password', 'require', '密码不能为空'],
				//['verify','require|captcha','验证码不能为空|验证码不正确'],
			]);
			if (!$validate->check($data)){
				return returnerror($validate->getError());
			}
			$uinfo = Db::table('tbl_user')->where(['username'=>$data['account']])->find();
			if($uinfo['status'] !==0){
				return returnerror('禁止登陆');
			}
			if(!empty($uinfo) && $uinfo['password'] == password($data['password'])){
				session('userid',$uinfo['id']);
				return returnsuccess('登陆成功');
			}
			return returnerror('登陆失败');
		}
		$this->assign('title',$config['title']);
		$this->assign('is_reg',$config['is_reg']);
		return view(); 
	}	
	public function logout(){
		session('userid',null);
		header('location:/cn');die();
	}
	public function register(){
		$uid = 0;
		$i = ssl_decode(input('i'));
		if($i){
			$uid  = $i;
		}
		$this->assign('uid',$uid);
		$config = Db::table('tbl_config')->field('title,is_reg,is_code,maxamount,miniamount,kou,kounum,fee,pfee,is_kou')->find();
		if(is_ajax()){
			//验证
			$validate = new \think\Validate([
				['account', 'require', '用户名不能为空'],
				['password', 'require', '密码不能为空'],
				['verify','require|captcha','验证码不能为空|验证码不正确'],
		
			]);
			//验证部分数据合法性
			if (!$validate->check($_POST)){
				return returnerror($validate->getError());
			}
			$uid = input('uid');
			Db::startTrans();
			if($config['is_reg'] == 1){
				Db::rollback();
				return returnerror('禁止注册');
			}
			if($config['is_code'] == 2){
				$uid = Db::table('tbl_code')->where(['code'=>input('code')])->value('uid');
				if($uid == ''){
					Db::rollback();
					return returnerror('无效邀请码');
				}
			}
			$fee = $config['fee'];
			$ptfee = $config['pfee'];
			if($uid != 0){
				$uinfo = Db::table('tbl_user')->where(['id'=>$uid,'is_all'=>2])->field('fee,ptfee')->find();
				if(!empty($uinfo)){
					$fee = $uinfo['fee'];
					$ptfee = $uinfo['ptfee'];	
				}else{
					$uid = 0;
				}	
			}
			//查询是否注册过
			$result = Db::table('tbl_user')->where(['username'=>trim(input('account'))])->field('id')->find();
			if(!empty($result)){
				Db::rollback();
				return returnerror('此账户已被注册');
			} 
			$ename = Db::table('tbl_ename_index')->where(['status'=>1])->field('id,ename')->find();
			if(empty($ename)){
				Db::rollback();
				return returnerror('无可用域名');
			} 
			$u_data = [];
			$u_data['username']  = trim(input('account'));
			$u_data['password'] = password(trim(input('password')));
			$u_data['ename'] = $ename['ename'];
			$u_data['fid'] = $uid;
			$u_data['is_all'] = 1;
			$u_data['fee'] = $fee;
			$u_data['ptfee'] = $ptfee;
			$u_data['max'] = $config['maxamount'];
			$u_data['mini'] = $config['miniamount'];
			$userid = Db::table('tbl_user')->insertGetId($u_data);
			if(!$userid){
				Db::rollback();
				return returnerror('注册失败');
			}
			$ename_data = [];
			$ename_data['uid'] = $userid;
			$ename_data['utime'] = date('Y-m-d H:i:s');
			$ename_data['status'] =2;
			if(!Db::table('tbl_ename_index')->where(['id'=>$ename['id']])->update($ename_data)){
				Db::rollback();
				return returnerror('注册失败');
			}
			if($config['is_code'] == 2){
				$code_data = [];
				$code_data['utime'] = time();
				$code_data['userid'] = $userid;
				$code_data['status'] = 2;
				if(!Db::table('tbl_code')->where(['code'=>input('code')])->update($code_data)){
					Db::rollback();
					return returnerror('注册失败');
				}
			}	
			if($config['kou'] == 2){
				$kou_data = [];
				$kou_data['uid'] = $userid;
				$kou_data['num'] = $config['kounum'];
				$kou_data['surplus'] = $config['kounum'];
				$kou_data['utime'] = time();
				if(!Db::table('tbl_cus')->insert($kou_data)){
					Db::rollback();
					return returnerror('注册失败');
				}
			}
			return returnsuccess('注册成功');
			Db::commit();
		}
		$this->assign('is_code',$config['is_code']);
		$this->assign('title',$config['title']);
		return view();
	}

	 
}
