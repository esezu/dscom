<?php
namespace app\cn\controller; 
use think\Db;
use think\Controller;
use think\Session;
class OrderController extends BaseController{	
	public function _initialize(){
		parent::_initialize();
		$this->uid = session('userid');
	}
    public function index(){ 
    	if(is_ajax()){
    		$where['status'] = ['in',[2]];
    		$where['uid']=$this->uid;
    		$keys = trim(input('keys'));
    		if($keys ){
				$where['ordersn'] = $keys;
			}
    		if(input('stime')){
				$where['paytime'] = ['>',strtotime(input('stime').' 00:00:00')];
			}
			if(input('etime')){
				$where['paytime'] = ['<',strtotime(input('etime').' 23:59:59')];
			}
			$list = Db::table('tbl_order')->where($where)->order('id desc')->field('ordersn,vid,buyid,payamount,amount,allamount,amount,ctime,paytime,title,tos,status')->page(input('page'), input('limit'))->select();
			foreach($list as &$v){
				$v['amount'] = number_format($v['amount']/100,2);
				if($v['status'] == 1){
					$v['payamount'] = '-';
					$v['status'] = '<span class ="wei">未支付</span>';
					$v['paytime'] = $v['ctime'];;
				}
				if($v['status'] == 2){
					$v['payamount'] = number_format($v['allamount']/100,2); 
					$v['status'] = '<span style ="color:red;" >已支付</span>';;
				}	
			}
			$toole = Db::table('tbl_order')->where($where)->order('id desc')->count();
			return returnlaydate('获取成功',$list,$toole);
    	}else{
    		$cwhere['status'] = ['in',[2]];
    		$cwhere['uid']=$this->uid;
    		$jnum =   Db::table('tbl_order')->where($cwhere)->whereTime('paytime', 'today')->count();
    		$jprice = Db::table('tbl_order')->where($cwhere)->whereTime('paytime', 'today')->sum('allamount');
    		$znum =   Db::table('tbl_order')->where($cwhere)->whereTime('paytime', 'yesterday')->count();
    		$zprice = Db::table('tbl_order')->where($cwhere)->whereTime('paytime', 'yesterday')->sum('allamount');
    		$num =    Db::table('tbl_order')->where($cwhere)->count();
    		$price =  Db::table('tbl_order')->where($cwhere)->sum('allamount');
    		$this->assign('jnum',number_format($jnum).'单');
    		$this->assign('znum',number_format($znum).'单');
    		$this->assign('num',number_format($num).'单');
    		$this->assign('jprice',number_format($jprice/100,2).'元');
    		$this->assign('zprice',number_format($zprice/100,2).'元');
    		$this->assign('price',number_format($price/100,2).'元');
    	}
    	return view();
    }

    public function money(){
    	if(is_ajax()){
    		$where['uid']=$this->uid;
    		$keys = trim(input('keys'));
    		if($keys ){
				$where['ordersn'] = $keys;
			}
    		if(input('stime')){
				$where['paytime'] = ['>',strtotime(input('stime').' 00:00:00')];
			}
			if(input('etime')){
				$where['paytime'] = ['<',strtotime(input('etime').' 23:59:59')];
			}
			$list	= Db::table('tbl_user_money')->where($where)->order(' status asc , id desc')->field('ordersn,uid,status,ctime,money,dotime')->page(input('page'), input('limit'))->select();
			foreach($list as &$v){
				$v['money'] = number_format($v['money']/100,2);
				if($v['status'] == 1){
					$v['status'] = '未打款';
					$v['dotime'] = '-';
				}
				if($v['status'] == 2){
					$v['status'] = '<span style= "color:red">已打款</span>';
				}
				if($v['status'] == 3){
					$v['status'] = '拒绝';
				}
			}
			$toole = Db::table('tbl_user_money')->where($where)->order('id desc')->count();
			return returnlaydate('获取成功',$list,$toole);
    	}
    	return view();
    }
    public function domoney(){
    	$money = Db::table('tbl_user')->where(['id'=>$this->uid])->value('money');
    	if(is_ajax()){
    		$data['money'] = (int)($_POST['money']*100);
    		$data['img'] = $_POST['img'];
    		if($data['money'] <=0){
    			return returnerror('请输入正确金额');
    		}
    		if($money - $data['money'] <0){
    			return returnerror('提现金额不能大于'.number_format($money/100,2));
    		}
    		$config = Db::table('tbl_config')->where(['id'=>1])->field('getmaxmoney,getminimoney')->find();
    		if($config['getminimoney'] > 0 && $data['money'] < $config['getminimoney'] ){
    			return returnerror('提现金额不能小于 :'.number_format($config['getminimoney']/100,2).'元');
    		}
    		if($config['getmaxmoney'] > 0 && $data['money'] > $config['getmaxmoney'] ){
    			return returnerror('提现金额不能大于于 :'.number_format($config['getmaxmoney']/100,2).'元');
    		}
    		if($data['img'] ==''){
    			return returnerror('请上传收款码');
    		} 
    		$data['ctime'] = date('Y-m-d H:i:s');
    		$data['ordersn'] = ordersn();
    		$data['status'] = 1;
    		$data['uid'] = $this->uid;
    		$data['dotime'] = '0000-00-00 00:00:00';
    		//开启事务 
			Db::startTrans();
			if(!Db::table('tbl_user')->where(['id'=>$this->uid])->setDec('money',$data['money'])){
				Db::rollback();
				return returnerror('操作失败');
			}
			if(!Db::table('tbl_user')->where(['id'=>$this->uid])->setInc('getmoney',$data['money'])){
				Db::rollback();
				return returnerror('操作失败');
			}
			if(!Db::table('tbl_user_money')->insert($data)){
				Db::rollback();
				return returnerror('操作失败');
			}
			Db::commit();
			return returnsuccess('申请成功');
    	}
    	$this->assign('money', number_format($money/100,2));
    	return view();
    }
    public function upload(){
    	$info = $this->request->file('file')->validate(['ext'=>'jpg,png,gif'])->move('./public' . DS . 'uploads');
    	$data['code'] = 0;
    	$data['msg'] = '';
    	$data['data']['src'] = trim($info->getpathName(),'.');
    	echo json_encode($data);die();
    }
    public function pushorder(){
    		if(is_ajax()){
    			$where['status'] = 2;
	    		$where['fid']=$this->uid;
	    		$keys = trim(input('keys'));
	    		if($keys ){
					$where['ordersn'] = $keys;
				}
	    		if(input('stime')){
					$where['paytime'] = ['>',strtotime(input('stime').' 00:00:00')];
				}
				if(input('etime')){
					$where['paytime'] = ['<',strtotime(input('etime').' 23:59:59')];
				}
			
				$list	= Db::table('tbl_order')->where($where)->order('id desc')->field('ordersn,vid,uid,buyid,payamount,fee,paytime,title,tos,status')->page(input('page'), input('limit'))->select();

				$uidlist = array_unique(array_column($list,'uid'));
				$userlist = array_column(Db::table('tbl_user')->where(['id'=>['in',$uidlist]])->field('id,username')->select(),'username','id');

				foreach($list as &$v){
					$v['payamount'] = number_format($v['fee']/100,2);
					$v['status'] = '已支付';
					$v['buyid'] = $userlist[$v['uid']];
				}
				$toole = Db::table('tbl_order')->where($where)->order('id desc')->count();
				return returnlaydate('获取成功',$list,$toole);
	    	}
    	return view();
    }	 
}
