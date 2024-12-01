<?php
namespace app\admins\controller;
use think\Db;
use think\model;
class CusController extends BaseController{	
	protected function _initialize(){
		parent::_initialize();
	}
	public function index(){
		 if(is_ajax()){
  			$where = [];
    		$keys = trim(input('keys'));
    		if($keys ){
				$where['tbl_user.username'] = $keys;
			}
			$list	= Db::table('tbl_cus')->join('tbl_user','tbl_cus.uid=tbl_user.id')->where($where)->field('tbl_cus.id,tbl_cus.uid,tbl_cus.num,tbl_cus.surplus,tbl_user.username')->page(input('page'), input('limit'))->select();
		 	foreach($list as &$v){
		 		$v['fuck'] = '<button type="button"  class="layui-btn layui-btn-sm layui-btn-normal" onclick="getlink('.$v['id'].')">编辑</button><button type="button"  class="layui-btn layui-btn-sm layui-btn-normal layui-btn-danger" onclick="del('.$v['id'].')">删除</button>';
		 	}
			$toole = Db::table('tbl_cus')->join('tbl_user','tbl_cus.uid=tbl_user.id')->where($where)->count();
			return returnlaydate('获取成功',$list,$toole);
    	}
    	return view();
	}
	public function order(){
		if(is_ajax()){
    			$where['status'] = 3;
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
				$list = Db::table('tbl_order')->where($where)->order('id desc')->field('ordersn,vid,uid,buyid,payamount,paytime,title,tos,status')->page(input('page'), input('limit'))->select();

				$uidlist = array_unique(array_column($list,'uid'));

				$userlist = array_column(Db::table('tbl_user')->where(['id'=>['in',$uidlist]])->field('id,username')->select(),'username','id');

				foreach($list as &$v){
					$v['payamount'] = number_format($v['payamount']/100,2);
					$v['status'] = '已支付';
					$v['buyid'] = $userlist[$v['uid']];
				}
				$toole = Db::table('tbl_order')->where($where)->order('id desc')->count();
				return returnlaydate('获取成功',$list,$toole);
	    	}
    	return view();
	}
	public function del(){
        $id= input('id');
        if(Db::table('tbl_cus')->where(['id'=>$id])->delete()){
            return returnsuccess('删除成功');
        }
        return returnerror('删除失败');
    }
     public function edit(){
        $id = input('id');
        $vinfo = Db::table('tbl_cus')->where(['id'=>$id])->find();
        if(empty($vinfo)){
            echo '暂无此数据';die();
        }
        if(is_ajax()){
            $id = input('id');
            $data['surplus'] = (int)$_POST['surplus'];
            $data['num'] = (int)$_POST['num'];
           	if($data['num'] <= 0){
    			return returnerror('当前值不能小于0');
    		}
    		if($data['surplus'] <= 0){
    			return returnerror('扣量值不能小于0');
    		}
            $data['utime'] = time();
            if(Db::table('tbl_cus')->where(['id'=>$id])->update($data)){
                return returnsuccess('修改成功');
            }
            return returnerror('修改失败');
        }
        $this->assign('username',Db::table('tbl_user')->where(['id'=>$vinfo['uid']])->value('username'));
        $this->assign('cinfo',$vinfo);
        return view();
    }
    public function add(){
    	if(is_ajax()){

    		$data['uid'] =(int)input('uid');
    		$data['num'] =(int)input('num');
    		$data['surplus'] = input('surplus');

    		if($data['uid'] == ''){
    			return returnerror('请选择用户');
    		}
    		if($data['num'] <= 0){
    			return returnerror('当前值不能小于0');
    		}
    		if($data['surplus'] <= 0){
    			return returnerror('扣量值不能小于0');
    		}
    		$data['utime'] = time();
    		if(Db::table('tbl_cus')->where(['uid'=>$data['uid']])->value('id')){
    			return returnerror('请勿重复添加');
    		}

    		
    		if(Db::table('tbl_cus')->insert($data)){
    			return returnsuccess('添加成功');
    		} 
    		return returnerror('添加失败');
    	}
    	$idlist = array_column(Db::table('tbl_cus')->field('uid')->select(),'uid');
    	$ulist = Db::table('tbl_user')->where(['id'=>['not in',$idlist]])->field('id,username')->select();
    	$this->assign('ulist',$ulist);
    	return view();
    }
}
