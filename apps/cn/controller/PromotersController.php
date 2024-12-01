<?php
namespace app\cn\controller;
use think\Db;
use think\Controller;
use think\Session;
class PromotersController extends BaseController{
    public function _initialize(){
        parent::_initialize();
    }
    public function index(){
        return view();
    }
    public function video(){
        $cost =array_column( Db::table('tbl_cost')->select(),null,'id');
        if(is_ajax()){
            $where =[];
            $key = input('keys');
            if($key){
                $where['cost'] = $key;
            }
            //查询已提取的链接
            $vlist = array_unique(array_column(Db::table('tbl_url')->where(['uid'=>session('userid')])->field('vid')->select(),'vid'));
            if(!empty($vlist)){
                $where['id']= ['not in',$vlist];    		}
            $list = Db::table('tbl_video')->where($where)->field('ctime,id,cost,cover,title')->page(input('page'), input('limit'))->order('id desc')->select();
            foreach($list as &$v){
                $v['cost'] = $cost[$v['cost']]['cost'];
                $v['ctime'] = date('Ymd His',$v['ctime']);
                $v['cover'] = '<img src = "'.$v['cover'].'" class ="showimg" />';
                $v['fuck'] = '<button type="button"  class="layui-btn layui-btn-sm layui-btn-normal" onclick="getlink('.$v['id'].')">获取链接</button>';
            }
            $toole = Db::table('tbl_video')->where($where)->count();
            return returnlaydate('获取成功',$list,$toole);
        }
        $this->assign('cost',$cost);
        return view();
    }
    public function urllist(){
        if(is_ajax()){
            $where =[];
            $where['uid'] = session('userid');
            $key = input('keys');
            if($key){
                $where['is_he'] = $key;
            }
            $list = Db::table('tbl_url')->where($where)->page(input('page'), input('limit'))->order('id desc')->select();
            foreach($list as &$v){
                if($v['box_video_id']){
                    $v['msg'] = "<a onclick='editboxvide(".$v['box_video_id'].")'>".$v['msg']."</a>";
                }
                $v['qrcode'] = "<img height='100%' src = '/cn/qr?url=".urlencode($v['url'])."' >";
                $v['fuck'] = '<button type="button"  class="layui-btn layui-btn-sm layui-btn-normal" onclick="copelink(\''.$v['url'].'\')">复制连接</button>';
                $v['fuck'] .= '<button type="button"  class="layui-btn layui-btn-sm layui-btn-normal" onclick="javascript:window.location.href=\''.'/cn/qr?url='.urlencode($v['url']).'\'">下载二维码</button>';
                $v['fuck'] .= '<button type="button"  class="layui-btn layui-btn-sm layui-btn-normal layui-btn-danger " onclick="delurl('.$v['id'].')">删除</button>';
            }
            $toole = Db::table('tbl_url')->where($where)->count();
            return returnlaydate('获取成功',$list,$toole);
        }
        return view();
    }
    public function qrcode(){
        $id = input('id');
        $ty = input('ty')?input('ty'):1;
        $boxvideo = input('boxvideo')?input('boxvideo'):false;
        $video = Db::table('tbl_video')->where(['id'=>$id])->field('title,id')->find();
        $data['ctime'] = date('Y-m-d H:i:s');
        $data['uid'] = session('userid');
        if(!empty($video)){
            $data['msg'] = $video['title'];
            $data['is_he'] = 2;
            $data['url'] = $this->getulr($ty,$video['id']);
            $data['vid'] = $video['id'];
            $data['dyurl'] = $this->getulrlenth($video['id']);;
        }elseif ($boxvideo) {
            $boxvideodata = [
                'video' =>  $boxvideo,
                'creat_time'=>date('Y-m-d H:i:s'),
                'uid' => session('userid')
            ];
            $boxvideoid = Db::table('tbl_box_video')->insertGetId($boxvideodata);
            $data['box_video_id'] = $boxvideoid;
            $data['msg'] = '盒子推广链接';
            $data['is_he'] = 1;
            $data['url'] = $this->getulr($ty,'',$boxvideoid);
            $data['dyurl'] = $this->getulrlenth('',$boxvideoid);
        }else{
            $data['msg'] = '总链接';
            $data['is_he'] = 1;
            $data['url'] = $this->getulr($ty);
            $data['dyurl'] = $this->getulrlenth();
        }
        Db::table('tbl_url')->insert($data);
        $this->assign('url',$data['url']);
        return view();
    }
    public function delurl(){
        $id = input('id');
        if(Db::table('tbl_url')->where(['uid'=>session('userid'),'id'=>$id])->delete()){
            return returnsuccess('删除成功');
        }
        return returnerror('删除失败');
    }
    public function delurlall(){
        if(Db::table('tbl_url')->where(['uid'=>session('userid')])->delete()){
            return returnsuccess('删除成功');
        }
        return returnerror('删除失败');
    }
    #获取盒子视频链接信息
    public function getboxvideoinfo(){
        $id = input('id');
        if($res = Db::table('tbl_box_video')->where(['uid'=>session('userid'),'id'=>$id])->find()){
            return returnsuccess('获取成功',200,$res);
        }
        return returnerror('信息不存在');
    }
    #编辑盒子视频链接信息
    public function editboxvideoinfo(){
        $id = input('id');
        $video = input('video');
        if($res = Db::table('tbl_box_video')->where(['uid'=>session('userid'),'id'=>$id])->update(['video'=>$video])){
            return returnsuccess('修改成功');
        }
        return returnerror('修改失败');
    }

}
