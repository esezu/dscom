<?php
namespace app\admins\controller;
use think\Db;
use think\Controller;
use think\Session;
class BaseController extends Controller{
	protected function _initialize(){ 
	   
		$note = [
			'home/login'
		];
		if( !in_array(strtolower(request()->controller().'/'.request()->action()),$note)){
			$this->permissions();
		}
	}
    protected function permissions(){
   		if(empty(session('adminid'))) {
            $this->redirect('home/login');
        }
	}
	public function loginout(){
		session("adminid", null);
		return ajaxSuccess('退出成功');
	}  
	
	
}
