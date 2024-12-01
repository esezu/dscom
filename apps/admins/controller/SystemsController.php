<?php
namespace app\admins\controller;

use think\Cache;
use think\Db;
class SystemsController extends BaseController{	
	public function _initialize(){
		parent::_initialize();
	} 
    public function index(){
    	$config = Db::table('tbl_config')->where(['id'=>1])->find();
    	$config['enameamount'] = $config['enameamount']/100;
    	$config['getminimoney'] = $config['getminimoney']/100;
    	$config['getmaxmoney'] = $config['getmaxmoney']/100;
    	$this->assign('config',$config);
        return view();
    }
    public function updes(){
		$status  =input('a')=='true'?2:1;
		$name = input('n');
		if(Db::table('tbl_config')->where(['id'=>1])->update([$name=>$status])){
			return returnsuccess('修改成功');
		}
		return returnerror('修改失败'); 
	}
	public function upde(){
		$data[input('n')] = in_array(input('n'),['code_price','enameamount','getminimoney','getmaxmoney'])?input('v')*100:input('v');
		$data['utime'] = time();
		if(input('n') !== ''  && !$data[input('n')] !=='' && Db::table('tbl_config')->where(['id'=>1])->update($data)){
			return returnsuccess('修改成功',200,input('v'));
		}
		return returnerror('修改失败'); 
	}
	public function paylist(){
		$list = Db::table('tbl_pay_type')->field('id,url,title,key,ctime,utime,appid')->order('id desc')->select();
		foreach($list as &$v){
			$v['ctime'] = date('Y-m-d H:i:s',$v['ctime']);
			$v['utime'] = date('Y-m-d H:i:s',$v['utime']);
			$v['fuck']  = '<button type="button"  class="layui-btn layui-btn-sm layui-btn-normal" onclick="edit('.$v['id'].')">编辑</button>';
		}
		$this->assign('list',$list);
		return view();
	}
	public function edit(){
		if(is_ajax()){
			$data['title'] = trim(input('title'));
			$data['url'] = trim(input('url'));
			$data['key'] = trim(input('key'));
			$data['appid'] = trim(input('appid'));
			$data['utime'] = time();
			$id = trim(input('id'));
			if(Db::table('tbl_pay_type')->where(['id'=>$id])->update($data)){
				return returnsuccess('修改成功');
			}
			return returnerror('修改失败');
		}
		$id  = input('id');
		$this->assign('id',$id);
		$info = Db::table('tbl_pay_type')->where(['id'=>$id])->find();
		$this->assign('info',$info);
		return view();
	}
	public function payedit(){
		if(is_ajax()){
		 	 

		 	$data['paytype'] = input('paytype');
		 	$data['no_wx'] = input('no_wx');
			$data['utime']  = time();
 			if(Db::table('tbl_config')->where(['id'=>1])->update($data)){
 				return returnsuccess('修改成功');
 			}
			return returnerror('修改失败');
 		}
		$paylist = DB::table('tbl_pay_type')->field('id,title')->order('id desc')->select();
		$info = Db::table('tbl_config')->field("paytype,maxamount,miniamount,no_wx")->find();
	
		$this->assign('info',$info);
		$this->assign('paylist',$paylist);
		return view();
	}
	#公众号列表
    public function mpwxlist(){
        if(is_ajax()){
            $where = [];
            $keys = input('keys');
            if(!empty($keys)){
                $where['title'] = $keys;
            }
            $list = Db::table('tbl_mpwx')->order('id desc')->select();
            foreach($list as &$v){
                $v['ctime'] = date('Y-m-d H:i:s',$v['ctime']);
                $v['utime'] = date('Y-m-d H:i:s',$v['utime']);
                $v['fuck']  = '<button type="button"  class="layui-btn layui-btn-sm layui-btn-normal" onclick="edit('.$v['id'].')">编辑</button><button type="button"  class="layui-btn layui-btn-sm layui-btn-normal layui-btn-danger" onclick="del('.$v['id'].')">删除</button>';
            }
            $count = Db::table('tbl_mpwx')->where($where)->count();
            return returnlay($list,$count);
        }
        return view();
    }
    #新增公众号
    public function mpwxadd(){
        if(is_ajax()){
            $data['title'] = input('title');
            $data['appid'] = input('appid');
            $data['appsecret'] = input('appsecret');
            $data['ctime'] = time();
            $data['utime'] = time();
            if(Db::table('tbl_mpwx')->insert($data)){
                return returnsuccess('添加成功');
            }
            return returerrot('添加失败');
        }
        return view();
    }
    #编辑公众号
    public function mpwxeidt(){
        $id = input('id');
        if (!$res = Db::table('tbl_mpwx')->where(['id'=>$id])->find()) $this->error('公众号不存在');
        if(is_ajax()){
            $data['id'] = $res['id'];
            $data['title'] = input('title');
            $data['appid'] = input('appid');
            $data['appsecret'] = input('appsecret');
            $data['utime'] = time();
            if(Db::table('tbl_mpwx')->update($data)){
                return returnsuccess('更新成功');
            }
            return returerrot('更新失败');
        }
        $this->assign('data',$res);
        return view();
    }
    #删除公众号
    public function mpwxdel(){
        $id = input('id');
        if(Db::table('tbl_mpwx')->where(['id'=>$id])->delete()){
            return returnsuccess('删除成功');
        }
        return returnerror('删除失败');
    }

}
