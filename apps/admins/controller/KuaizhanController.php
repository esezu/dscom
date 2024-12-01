<?php
namespace app\admins\controller;

use think\Db;
class KuaizhanController extends BaseController{
	public function _initialize(){
	   parent::_initialize();
	}
    public function index(){
    	 if(is_ajax()){
            $where = [];
            $keys = input('keys');
            if(!empty($keys)){
                $where['ename'] = $keys;
            }
            $list = Db::table('tbl_ename_kuaizhan')
            ->where($where)
            ->order('id desc')
            ->page(input('page',1),input('limit'))
            ->select();
            foreach($list as &$v){
                $v['fuck'] = '';
                if($v['status'] == 1){
                    $v['fuck'] = '<button type="button"  class="layui-btn layui-btn-sm layui-btn-normal" onclick="st('.$v['id'].',2)">开启</button>';
                    $v['status'] ='未开启';
                }
                if($v['status'] == 2){
                     $v['fuck'] = '<button type="button"  class="layui-btn layui-btn-sm layui-btn-normal layui-btn-warm"  onclick="st('.$v['id'].',1)">关闭</button>';
                     $v['status'] ='使用中';
                }
                if($v['status'] == 3){
                    $v['status'] = '死亡';
                }
                $v['fuck'] .= '<button type="button"  class="layui-btn layui-btn-sm layui-btn-normal layui-btn-danger" onclick="del('.$v['id'].')">删除</button>';

            }
            $count = Db::table('tbl_ename_kuaizhan')->where($where)->count();
            return returnlay($list,$count);
        }
        return view();
    }
    public function dels(){
        $id = input('id');
        if(Db::table('tbl_ename_kuaizhan')->where(['id'=>$id])->delete()){
            return returnsuccess('删除成功');
        }
        return returnerror('删除失败'); 
    }
    public function st(){
        $id  = input('id');
        $st  = input('st');
        $data = [];
        $data['status'] = $st;
        if($st == 2){
           $data['utime'] =  date('Y-m-d H:i:s');
        }
        if(Db::table('tbl_ename_kuaizhan')->where(['id'=>$id])->update($data)){
            return returnsuccess('设置成功');
        }
        return returnerror('设置失败');
    }
    public function adds(){
        $res  = $_POST['ts'];
        $list = explode("\n",$res);
        $data = [];
        foreach($list as $v){
            $time = date('Y-m-d H:i:s');
            $one = [];
            $one['ename'] = $v;
            $one['ctime'] = $time;
            $one['status'] = 1;
            $data[] = $one;
        }
        if(Db::table('tbl_ename_kuaizhan')->insertAll($data)){
            return returnsuccess('添加成功');
        }
        return returnerror('添加失败');
    }
    public function deldile(){
        if(Db::table('tbl_ename_kuaizhan')->where(['status'=>3])->delete()){
            return returnsuccess('删除成功');
        }
        return returnerror('删除失败'); 
    }
 
}
