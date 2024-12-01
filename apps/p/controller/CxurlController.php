<?php
namespace app\p\controller;
use think\Db;
use think\Controller;
use think\Request;
class CxurlController extends BaseController{
    public function index(){
        $ename = Db::table('tbl_ename')->where(['status'=>2])->limit(2)->field('id,ename')->select();
        $domainsx = Request::instance();
        $domainsc =$domainsx->domain();
        if(!empty($ename)){
            foreach($ename as $v){
                //$url="https://api.uouin.com/index.php/index/Jiance/add?username=2468218236&key=H3SHYmjGIpFLk9d&type=wx&url=" . $v['ename'];
                $url=$domainsc."/wxcxurl?url=http%3A%2F%2F" . $v['ename'];
                //$url="http://check.uomg.com/api/urlsec/vx?token=1c649ea978a81e86dbc1d08808520c6a&domain=" . $v['ename'];
                $json=file_get_contents($url);
                var_dump($json);
                $arr=json_decode($json,1);
                //if(isset($arr['code']) && $arr['code']=='1002'){
                if(isset($arr['code']) && $arr['code']=='201'){    
                    Db::table('tbl_ename')->where(['id'=>$v['id']])->update(['status'=>3,'dtime'=>date('Y-m-d H:i:s')]);
                    if(Db::table('tbl_ename')->where(['status'=>1])->count() == 0){
                        echo '域名【'. $v['ename'] .'】已经被标红，更换域名失败，没有可更换的域名，请添加可用域名';
                    }else{
                        $isEame = Db::table('tbl_ename')->where(['status'=>1])->find();
                        if($isEame){
                            $res = Db::table('tbl_ename')->where(['id'=>$isEame['id']])->update(['status'=>2,'utime'=>date('Y-m-d H:i:s')]);
                            if($res){
                                echo '域名【'. $v['ename'] .'】已经被标红，更换新域名【'.$isEame['ename'].'】成功！';
                            }else{
                                echo '域名【'. $v['ename'] .'】已经被标红，更换域名失败,请检查程序';
                            }
                        }else{
                            echo '域名【'. $v['ename'] .'】已经被标红，更换域名失败，没有可更换的域名，请添加可用域名';
                        }
                    }
                }
            }
        }else{
            $res = Db::table('tbl_ename')->where(['status'=>1])->limit(1)->update(['status'=>2,'utime'=>date('Y-m-d H:i:s')]);
            if($res){
                echo '平台没有使用中的域名,启动1个新域名成功';
            }else{
                echo '没有可用域名';
            }
        }
    }
}
