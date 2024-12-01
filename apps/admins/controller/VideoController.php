<?php
namespace app\admins\controller;

use think\Db;
class VideoController extends BaseController{	
	public function _initialize(){
		parent::_initialize();
	} 
	
	public function classl(){
	$res=Db::table('tbl_cost')->select();
		if(is_ajax()){
			foreach($res as &$v){
    			$v['id'] = $v['id'];
    			$v['title'] = $v['cost'];
    			$v['fuck'] = '<button type="button"  class="layui-btn layui-btn-sm layui-btn-normal" onclick="getlink('.$v['id'].')">编辑</button><button type="button"  class="layui-btn layui-btn-sm layui-btn-normal layui-btn-danger" onclick="delclass('.$v['id'].')">删除</button>';
    		}	
			
		return returnlaydate('获取成功',$res);
		}

		return view();
	}
	
	public function addclass(){
		$name=input('name');
		$data['cost']=$name;
	    $new =$data;
	    $res = Db::table('tbl_cost')->insert($new);
	  
		if($res){
			return returnsuccess('新增成功');
		}
		
		return returnerror('新增失败');
		
	}
	
	
	
	
	public function editclass(){
		$name=input('name');
		$id = input('id');
		$data['cost']=$name;
		$res=Db::table('tbl_cost')->where(['id'=>$id])->update($data);
		if($res){
			return returnsuccess('修改成功');
		}
		
		return returnerror('修改失败');
		
	}
	
	
	public function delclass(){
        $id= input('id');
        if(Db::table('tbl_cost')->where(['id'=>$id])->delete()){
            return returnsuccess('删除成功');
        }
       return returnerror('删除失败');
    }
	
	
	
    public function index(){ 
	 	$cost =array_column( Db::table('tbl_cost')->select(),null,'id');
    	if(is_ajax()){
    		$where =[];
    		$key = input('keys'); 
    		if($key){
    			$where['cost'] = $key;
    		}
            if(input('title')){
                $where['title'] = ['like','%'.input('title').'%'];
            }
    		$vlist = array_unique(array_column(Db::table('tbl_url')->where(['uid'=>session('userid')])->field('vid')->select(),'vid'));
    		if(!empty($vlist)){
    			$where['id']= ['not in',$vlist];    		}
    		$list = Db::table('tbl_video')->where($where)->page(input('page'), input('limit'))->order('id desc')->select();
    		foreach($list as &$v){
    			$v['cost'] = $cost[$v['cost']]['cost'];
    			$v['ctime'] = date('Ymd His',$v['ctime']);
    			$v['cover'] = '<img src = "'.$v['cover'].'" class ="showimg" />';
    			$v['fuck'] = '<button type="button"  class="layui-btn layui-btn-sm layui-btn-normal" onclick="getlink('.$v['id'].')">编辑</button><button type="button"  class="layui-btn layui-btn-sm layui-btn-normal layui-btn-danger" onclick="del('.$v['id'].')">删除</button>';
    		}
    		$toole = Db::table('tbl_video')->where($where)->count();
			return returnlaydate('获取成功',$list,$toole);
    	}
    	$this->assign('cost',$cost);
    	return view();
    }
    public function del(){
        $id= input('id');
        if(Db::table('tbl_video')->where(['id'=>$id])->delete()){
            return returnsuccess('删除成功');
        }
        return returnerror('删除失败');
    }
    public function edit(){
        $id = input('id');

        $vinfo = Db::table('tbl_video')->where(['id'=>$id])->find();
        if(empty($vinfo)){
            echo '暂无此视频';die();
        }

        if(is_ajax()){
            $id = input('id');
            $data['title'] = $_POST['title'];
            $data['cover'] = $_POST['cover'];
            $data['hit'] = $_POST['hit'];
            $data['buymonry'] = $_POST['buymonry'];
            $data['url'] = $_POST['url'];
            $data['cost'] = $_POST['cost'];
            $data['utime'] = time();
            if(Db::table('tbl_video')->where(['id'=>$id])->update($data)){
                return returnsuccess('修改成功');
            }
            return returnerror('修改失败');


        }

        $this->assign('cost',Db::table('tbl_cost')->select());
        $this->assign('vinfo',$vinfo);
        return view();


    }
 
    public function sele(){

      

        $pagesize = 1;
        if(is_ajax()){
            $page = input('page',1);
            $pagestart = ($page-1)*$pagesize;
            $list = Db::table('tbl_video')->field('id,cover,url')->order('id desc')->limit($pagestart,$pagesize)->select(); 
            $idlist = [];
            foreach($list as $v){ 
               if(!$this->check_remote_file_exists($v['url'])){
                    $idlist[] = $v['id'];
                } 
            }
            echo json_encode(['code'=>200,'data'=>$idlist]);die();
        }else{
            $count = Db::table('tbl_video')->count();
            $this->assign('allnumber',$count);
            $this->assign('allpage',ceil($count/$pagesize));
            return view();
        }

        
    }
	public function check_remote_file_exists($url) {
        $curl = curl_init($url); // 不取回数据
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET'); // 发送请求
        $result = curl_exec($curl);
        $found = false; // 如果请求没有发送失败
        if ($result !== false) {
            $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($statusCode == 200) {
                $found = true;
            }
        }
        curl_close($curl);
        return $found;
    }
    public function dels(){

        $idlist = explode(',',trim(input('idlist'),','));

        if(!empty($idlist)){
            if(Db::table('tbl_video')->where(['id'=>['in',$idlist]])->delete()){
                return returnsuccess('删除成功');
            }
        }
        return returnerror('删除失败');
    }
    public function addlist(){
        if(is_ajax()){
            $time = time();
            $list = explode("\n",input('list'));
            $insert_data = [];
            foreach($list as $v){
                $one = explode('|', $v);
       
                if(count($one) != 4){
                    return returnerror($v.'错误');
                    exit;
                }
                $cost = $one[3];
                if($cost == ''){
                    return returnerror($v.'类型错误');
                    exit;
                }
                $res = Db::table('tbl_cost')->where(['cost' => $cost])->value('id');
                if($res){
                    $cost = $res;
                }else{
                    return returnerror($v.'类型不存在');
                    exit;
                }
                $data = [];
                $data['title']  = $one[1];
                $data['cover'] = $one[2];
                $data['ctime'] = $time;
                $data['hit'] = rand(10000,99999);
                $data['buymonry'] = rand(1000,10000);
                $data['url'] = $one[0];
                $data['cost'] =  $cost;
                $insert_data[] = $data;
            }
            if(Db::table('tbl_video')->insertAll($insert_data)){
                return returnsuccess('添加成功');
            }
            return returnerror('添加失败');
        }
    }
    public function ches(){
        if(is_ajax()){
            $ourlss = trim(input('ourlss')); 
            $nurlss = trim(input('nurlss')); 
            if($ourlss != '' && $nurlss != ''){
                Db::query(" update tbl_user set ename = REPLACE(ename,'{$ourlss}','{$nurlss}')");
            }
            return returnsuccess('修改成功');
        }else{
            return view();
        }
    }
    public function che(){
        if(is_ajax()){
            $ourl = trim(input('ourl')); 
            $nurl = trim(input('nurl')); 
            $ocove = trim(input('ocove')); 
            $ncove = trim(input('ncove'));
            if($ourl != '' && $nurl != ''){
                Db::query(" update tbl_video set url = REPLACE(url,'{$ourl}','{$nurl}')");
            }
            if($ocove != '' && $ncove != ''){
                Db::query(" update tbl_video set cover = REPLACE(cover,'{$ocove}','{$ncove}')");
            }
            return returnsuccess('修改成功');
        }else{
            return view();
        }
    }
    public function deleteall(){
        $res = explode('-',input('txt'));
        if(count($res) != 2){
            return returnerror('输入格式不正确'); 
        }
        $star = (int)$res[0];
        $end = (int)$res[1];
        if($star <=0 || $end <=0 || $star > $end){
            return returnerror('输入格式不正确'); 
        }
        if($end - $star < 0){
           return returnerror('添加失败'); 
        }
        $pagesize = abs(($end - $star +1)*17);
        $idlist = array_column(Db::table('tbl_video')->page($star,$pagesize)->field('id')->order('id desc')->select(),"id");
         
        if(Db::table('tbl_video')->where(['id'=>['in',$idlist]])->delete()){
            return returnsuccess('删除成功');
        }
        return returnerror('删除失败');
    }

}
