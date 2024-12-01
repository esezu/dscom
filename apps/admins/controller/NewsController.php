<?php
namespace app\admins\controller;
use think\Db;
use think\model;
class NewsController extends BaseController{	
	protected function _initialize(){
		parent::_initialize();
	}
	public function index(){
		$map = [];
		if(is_ajax()){
			$keys = input('keys');
			if($keys != ''){
				$map['title']  = ['like',"%{$keys}%"];
			} 
			$list = Db::table('tbl_news')->where($map)->page(input('page'),input('limit'))->order('id desc')->select();
			if(!empty($list)){
				foreach($list as &$v){
					$v['ctime'] = date('Y-m-d H:i:s',$v['ctime']);
					$v['fuck'] = '<button type="button" class="layui-btn layui-btn-sm layui-btn-normal" onclick="delnews(\''.$v['id'].'\')" >删除</button>';
				}
				 
			}
			$toole = Db::table('tbl_news')->where($map)->count();
			return returnlaydate('获取成功',$list,$toole);
		}
		return view();
	}
	public function info(){
		if(is_ajax()){
			$data['title'] = input('title');
			$data['content'] = input('content');
			$data['ctime'] = time();

		if(Db::table('tbl_news')->insert($data)){
			return returnsuccess('添加成功');
		}
		return returerrot('添加失败');
		}
		return view();
	} 
	public function deletenews(){
		$id = input('id');
		if(Db::table('tbl_news')->where(['id'=>$id])->delete()){
			return returnsuccess('删除成功');
		}
		return returerrot('删除失败');
	}


	 

}
