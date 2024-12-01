<?php
namespace app\admins\controller;

use think\Db;
class HomeController extends BaseController{	
	public function _initialize(){
		parent::_initialize();
		$config = Db::table('tbl_config')->find();
		$this->assign('username','打赏');
		$this->assign('title','打赏');
	} 
    public function index(){ 
	 	return view();
    }
	public function login(){
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
			$uinfo = Db::table('tbl_admin')->where(['account'=>$data['account']])->find();

		if(!empty($uinfo) && $uinfo['password'] == password($data['password'])){
	
				session('adminid',$uinfo['id']);
				return returnsuccess('登陆成功');
			}
			return returnerror('登陆失败');
		}
		return view(); 
	}	
	public function logout(){
		session("adminid", null);
		header('location:/admins');die();
	}
	public function repassword(){
        if(is_ajax()){
            $data = input('post.');
            $validate = new \think\Validate([
                ['oldpassword', 'require', '旧密码不能为空'],
                ['newpassword', 'require', '新密码不能为空'],
                ['renewpassword', 'require', '重复新密码不能为空'],
            ]);
            if (!$validate->check($data)){
                return returnerror($validate->getError());
            }
            if($data['newpassword'] != $data['renewpassword']) {
                return returnerror('两次输入密码不一致');
            }
            $uinfo = Db::table('tbl_admin')->where(['id'=>session('adminid')])->find();
            if(password($data['oldpassword']) != $uinfo['password']){
                return returnerror('旧密码不正确');
            }
            if(Db::table('tbl_admin')->where(['id'=>session('adminid')])->update(['password'=>password($data['newpassword'])])){
                return returnsuccess('修改成功');
            }else{
                return returnerror('修改失败');
            }
        }
        return view();
    }
	public function tt(){ 
		$weekmonety = array_column(Db::query("SELECT DATE_FORMAT(utime,'%Y-%m-%d') as time,sum(amount) as  money FROM tbl_sys_order WHERE utime > '".( date('Y-m-d 00:00:00',strtotime(date('Y-m-d 23:59:59'))-86400*7)) ."'  GROUP BY  time  "), 'money','time');
		$timelist  = [];

        $time = strtotime(date('Y-m-d 00:00:00',time()));

        for($i=6;$i>=0;$i--){

            $timelist[] = date('Y-m-d',$time- $i*86400);
        }
        foreach($timelist as $k=>$v){
            $price = 0;
            if(isset($weekmonety[$v])){
                $price += $weekmonety[$v];
            }
            $money[] = number_format($price/100,2, '.', '');
           
        }   
      
		$this->assign('money',json_encode($money));
		$this->assign('date',json_encode($timelist));   
		return view();
	}
	 
	function getnum(){
	 

		if(input('ty') == 'todaymoney'){
			$todaymoney = Db::table('tbl_sys_order')->whereTime('ctime', 'today')->sum('amount');
			return returnsuccess(number_format($todaymoney/100,2,'.',''));
		}
		if(input('ty') == 'yesterdaymoney'){
			$yesterdaymoney = Db::table('tbl_sys_order')->whereTime('ctime', 'yesterday')->sum('amount');
			return returnsuccess(number_format($yesterdaymoney/100,2,'.',''));
		}
		if(input('ty') == 'hit'){
			$hit = Db::table('tbl_hit')->count();
			return returnsuccess($hit);
		}
		if(input('ty') == 'allmoney'){
			$allmoney = Db::table('tbl_sys_order')->sum('amount');
			return returnsuccess(number_format($allmoney/100,2,'.',''));
		}
		if(input('ty') == 'todayls'){
			$todayls =   Db::table('tbl_order')->where(['status'=>2])->whereTime('ctime', 'today')->sum('payamount');
			return returnsuccess(number_format($todayls/100,2,'.',''));
		}
		if(input('ty') == 'yesterd'){
			$yesterd =   Db::table('tbl_order')->where(['status'=>2])->whereTime('ctime', 'yesterday')->sum('payamount');
			return returnsuccess(number_format($yesterd/100,2,'.',''));
		}
		if(input('ty') == 'allls'){
			$allls =     Db::table('tbl_order')->where(['status'=>2])->sum('payamount');
			return returnsuccess(number_format($allls/100,2,'.',''));
		}
 	}

}
