<?php
namespace app\p\controller;
use think\Db;
use think\Controller;
use think\Session;
class HomeController extends BaseController{
    public function getename(){
        header('Content-Type: text/html;charset=utf-8');
        header('Access-Control-Allow-Origin:*'); // *代表允许任何网址请求
        header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); // 允许请求的类型
        header('Access-Control-Allow-Credentials: true'); // 设置是否允许发送 cookies
        header('Access-Control-Allow-Headers: Content-Type,Content-Length,Accept-Encoding,X-Requested-with, Origin');
        $ename = Db::table('tbl_ename')->where(['status'=>2])->select();


        $url = '';
        if(!empty($ename)){
            //$url =  'http://'.uniqid().'.'.$ename[rand(0,count($ename)-1)]['ename'].'/l/';
            $url =  'http://'.uniqid().'.'.$ename[rand(0,count($ename)-1)]['ename'].'';
        }else{
            $url = 'https://www.baidu.com/';
        }
        echo $url;die();
    }
    public function getenames(){
        header('Content-Type: text/html;charset=utf-8');
        header('Access-Control-Allow-Origin:*'); // *代表允许任何网址请求
        header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); // 允许请求的类型
        header('Access-Control-Allow-Credentials: true'); // 设置是否允许发送 cookies
        header('Access-Control-Allow-Headers: Content-Type,Content-Length,Accept-Encoding,X-Requested-with, Origin');
        $ename = Db::table('tbl_ename')->where(['status'=>2])->select();
        $url = '';
        if(!empty($ename)){
            $url =  'http://'.uniqid().'.'.$ename[rand(0,count($ename)-1)]['ename'].'';
        }else{
            $url = 'https://www.baidu.com/';
        }
        $arrays=array(
                'url'=>$url,
                '1kjhadshjhjads'=>$url,
                '2kajshnashjasd'=>$url,
                '3lkaskjdhhj'=>$url,
                '4kjadshhjdsj'=>$url,
                '5askhjds'=>$url,
                '6kjdashjjsdah'=>$url,
                '7jkadshhj'=>$url
        );
        $urlss= json_encode($arrays, JSON_UNESCAPED_UNICODE);
        $urlkey= base64_encode($urlss);
        $arrayss=array('code'=>'1','data'=>$urlkey);
        $urls= json_encode($arrayss, JSON_UNESCAPED_UNICODE);
        
        echo $urls;die();
    }
    public function wxcxurl(){
        header('Content-Type: text/html;charset=utf-8');
        header('Access-Control-Allow-Origin:*'); // *代表允许任何网址请求
        header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); // 允许请求的类型
        header('Access-Control-Allow-Credentials: true'); // 设置是否允许发送 cookies
        header('Access-Control-Allow-Headers: Content-Type,Content-Length,Accept-Encoding,X-Requested-with, Origin');
        $ename = Db::table('tbl_ename')->where(['status'=>2])->select();
        $bmurl = "http%3A%2F%2F";//url编码http://
        $api = get_headers('http://mp.weixinbridge.com/mp/wapredirect?url='.$_GET['url']);
        $checkUrl = "/http[s]?:\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is";
        switch($_GET['url']){
            case (preg_match($checkUrl,$_GET['url'])):
            $result = array(
                'code' => 1003,
                'url' => $_GET['url'],
                'msg' => '你传入的URL不合法'
             );
            break;
            case ($api[6] !== 'Location: '.$_GET['url'].''):
            $result = array(
                'code' => 1002,
                'url' => $_GET['url'],
                'msg' => '域名被拦截'
             );
            break;
            case ($api[6] == 'Location: '.$_GET['url'].''):
            $result = array(
                'code' => 1001,
                'url' => $_GET['url'],
                'msg' => '域名正常'
             );
            break;
        }
        // 输出JSON
        echo json_encode($result,JSON_UNESCAPED_UNICODE);die();
    }
    public function index($id=''){

        $is_open = Db::table('tbl_config')->where(['id'=>1])->field('is_open,ename')->find();
        if($is_open['is_open'] ==1){
            header('location:'.$is_open['ename']);die();

        }
        if(!is_mobile()){
            header('location:'.$is_open['ename']);die();
        }
        $ename = Db::table('tbl_ename')->where(['status'=>2])->value('ename');
        if(count(explode('.', $ename)) == 2){
            $ename = md5(uniqid(microtime(true),true)).'.'.$ename;
        }
        if($ename == ''){
            header('location:/l/'.$id);die();
        }

        header('location:http://'.uniqid().'.'.$ename.'/l/'.$id);die();
    }
    public function lists($id){
        $k = '';
        $is_open = Db::table('tbl_config')->where(['id'=>1])->field('is_open,ename')->find();
        if($is_open['is_open'] ==1){
            header('location:'.$is_open['ename']);die();
        }
        if(!is_mobile()){
            header('location:'.$is_open['ename']);die();
        }
        $show = 0;
        $data= ssl_decode($id);
        if(isset($data['heziid']) && !empty($data['heziid'])){
            $boxvideo = Db::table('tbl_box_video')->where(['id'=>$data['heziid']])->value('video');
            if(!$boxvideo){
                $boxvideo = '';
            }
        }else{
            $boxvideo = '';
        }
        if(!$data || !isset($data['u']) || ($data['u'] != (int)$data['u']) || $data['u'] ==''){
            NOT_404();
        }
        $uinfo = Db::table('tbl_user')->where(['id'=>$data['u']])->field('id,vid,status,dayopen,tc,tcurl,weekopen,moonopen,dayamount,weekamount,moonamount')->find();
        if(empty($uinfo)){
            NOT_404();
        }
        if($uinfo['status'] == 1){
            NOT_404();
        }
        $vid = $uinfo['vid'];
        $v = '';
        $k = input('k');
        if(isset($data['v'])){
            $v = $data['v'];
            $video = Db::table('tbl_video')->where(['id'=>$v])->field('id,title,url')->find();
            $this->assign('video',$video);
            $show = 1;
        }
        Db::table('tbl_user')->where(['id'=>$data['u']])->setInc('hit');
        //记录ip
        if(!Db::table('tbl_hit')->where(['ip'=>ip()])->find()){
            $ipdata = [];
            $ipdata['ip'] = ip();
            $ipdata['ctime'] = date('Y-m-d H:i:s');
            $ipdata['uid'] = $data['u'];
            Db::table('tbl_hit')->insert($ipdata);
        }
        $cost = input('c','all');
        $ename = Db::table('tbl_ename')->where(['status'=>2])->value('ename');
        $this->assign('k',$k);
        $this->assign('show',$show);
        $this->assign('c',$cost);
        $this->assign('ename',$ename);
        $this->assign('id',$id);
        $this->assign('vid',$vid%2);
        $this->assign('uinfo',$uinfo);
        $this->assign('boxvideo',$boxvideo);
        if($vid == 1 || $vid == 2){
            return view('oldlsit');
        }
        if($vid == 3 || $vid == 4){
            return view('newlsit');
        }
        if($vid == 5){
            return view('list5');
        }
        if($vid == 6){
            return view('list6');
        }
         if($vid == 7){
            return view('list7');
        }
    }
    public function gl(){
        $limit = 20;
        $where = [];
        $list = [];
        $c = input('c','all');
        $page = input('page',1);
        $id = ssl_decode(input('id'));
        $uinfo = Db::table('tbl_user')->where(['id'=>$id['u']])->field('id,is_fixed,max,mini')->find();

        if(empty($uinfo)){
            echo json_encode($list);die();
        }
        $is_int = Db::table('tbl_config')->where(['id'=>1])->value('is_int');
        if($c == 'buy'){
            $arr=
            $olist = Db::table('tbl_order')
            ->where('buyid',ip())
            ->where('uid',$id['u'])
            ->where('status','in','2,3')
            ->order('id desc')
            ->field('vid,ordersn')
            ->select();

            $buyidlist = [];
            $oti = [];
            foreach($olist as $v){
                $buyidlist[] = $v['vid'];
                $oti[$v['vid']] = $v['ordersn'];
            }
            if(!empty($buyidlist)){
                $list = Db::table('tbl_video')->where(['id'=>['in',$buyidlist]])->page($page,$limit)->field('id,title,cover,hit,buymonry')->select();
                foreach($list as &$v){
                    $v['link'] = '/w/'.$oti[$v['id']];
                    $v['buynum'] = rand(100,3000);
                    $v['paynum'] = rand(1000,50000);
                    $v['urlp'] = 1;
                }
            }
            echo json_encode($list);die();
        }
        //包时
        $bao = false;//是否包时
        $buytime = Db::table('tbl_buy_time')->where(['ip'=>ip(),'uid'=>$id['u']])->find();
        if(!empty($buytime) && $buytime['endtime'] - time() >0){
            $bao = true;
        }

        if($c != 'all'){
            if(is_numeric($c)){
                $where['cost'] = $c;//是数字
            }else{
               $where['title'] = ['like','%'.$c.'%'];//不是数字
            }
        }
        /*
        if($c != 'all'){
            $where['title'] = ['like','%'.$c.'%'];
            //$where['cost'] = $c;
        }*/
        $list = Db::table('tbl_video')->where($where)->page($page,$limit)->field('id,title,cover,hit,buymonry')->orderRaw('rand()')->select();

        foreach($list as &$v){
            $one = [];
            $one['u'] = $id['u'];
            $one['i'] = $v['id'];
            $price = 0;

            if($uinfo['is_fixed'] == 2){
                $price = number_format($uinfo['max']/100,2);
            }else{
                $price = number_format(rand($uinfo['mini'],$uinfo['max'])/100,2);
            }
            if($is_int == 2){
                $price = (int)$price;
            }
            $v['price'] = $price;
            $v['urlp'] = '/pay/'.ssl_encode(['i'=>$v['id'],'u'=>$id['u'],'p'=>($price*100),'t'=>1]);
            $v['urld'] = '/pay/'.ssl_encode(['i'=>$v['id'],'u'=>$id['u'],'p'=>($price*100),'t'=>2]);
            $v['link'] = '/n/'.ssl_encode($one);
            $v['buynum'] = rand(100,3000);
            $v['paynum'] = rand(1000,50000);
            $v['bao'] = $bao;
            $v['playurl'] = '/play/'.ssl_encode($one);
        }
        echo json_encode($list);die();
    }
    public function cost(){
        $list = Db::table('tbl_cost')->select();
        array_push($list, ['id'=>'all','cost'=>'全部']);
        array_push($list, ['id'=>'buy','cost'=>'已购']);
        return returnsuccess($list);
    }
    public function videoinfo($id){
        $data = ssl_decode($id);
        //查看是否包月
        $uinfo = Db::table('tbl_buy_time')->where(['ip'=>ip(),'uid'=>$data['u']])->find();
        if(!empty($uinfo) && $uinfo['endtime'] - time() >0){
            //包月直接跳转等待页面
            $url = 'http://'.$_SERVER['HTTP_HOST'].'/play/'.$id;
            header('location:'.$url);die();
        }
        $this->assign('id',$id);
        return view();
    }
    public function showvideo(){
        $id = input('id');
        $res = ssl_decode($id);

        $uinfo = Db::table('tbl_user')->where(['id'=>$res['u']])->field('dayopen,weekopen,moonopen,dayamount,weekamount,moonamount,mini,max,is_fixed')->find();
        if(empty($uinfo)){
            echo '';die();
        }
        $vinfo = Db::table('tbl_video')->where(['id'=>$res['i']])->value('title');
        if(empty($vinfo)){
            echo '';die();
        }
        $is_int = Db::table('tbl_config')->where(['id'=>1])->value('is_int');
        $price = 0;
        if($uinfo['is_fixed'] == 2){
            $price = number_format($uinfo['max']/100,2);
        }else{
            $price = number_format(rand($uinfo['mini'],$uinfo['max'])/100,2);
        }
        if($is_int == 2){
            $price = (int)$price;
        }
        //支付方式
        $data = [];
        $payurl = '/pay/';
        $data[] = ['title'=>'观看单部视频('.$price.')元','url'=>$payurl.ssl_encode(['i'=>$res['i'],'u'=>$res['u'],'p'=>($price*100),'t'=>1])];
        if($uinfo['dayopen'] == 1){
            $data[] =  ['title'=>'包天('.number_format($uinfo['dayamount']/100).')元观看全部','url'=>$payurl.ssl_encode(['i'=>$res['i'],'u'=>$res['u'],'p'=>$uinfo['dayamount'],'t'=>2])];
        }
        if($uinfo['weekopen'] == 1){
            $data[] = ['title'=>'包周('.number_format($uinfo['weekamount']/100).')元观看全部','url'=>$payurl.ssl_encode(['i'=>$res['i'],'u'=>$res['u'],'p'=>$uinfo['weekamount'],'t'=>3])];
        }
        if($uinfo['moonopen'] == 1){

            $data[] = ['title'=>'包月('.number_format($uinfo['moonamount']/100).')元观看全部','url'=>$payurl.ssl_encode(['i'=>$res['i'],'u'=>$res['u'],'p'=>$uinfo['moonamount'],'t'=>4])];
        }
        $ht = '';
        foreach($data as $v){
            $ht.=  '<a  onclick="javascript:layer.load(3,{shade:0.6,content :\'正在支付\'});window.location.href =\''.$v['url'].'\'"><button class="solid button">'.$v['title'].'</button></a>';
        }
        $size = number_format(rand(2000,10000)/100,2);
        $leng = rand(1,59).':'.rand(1,59);
        $html = <<<HHH
            <div class="desc">
              <!--{$vinfo}-->
              <span style="color:#FFFF00;font-size:20px;">推荐使用包天包周包月</span>
              <br/>
              <span style="color:#FFFF00;font-size:20px;">可以看十余万部全视频</span>
              <br/>
              <span style="color:#FF8000;font-size:20px;">避免部分视频失效无法播放</span>
            </div>
            <div class="price"><span>{$price}</span> 元</div>
            <div class="btn-group">
                {$ht}
            </div>
            <div class="info">
              视频大小：<span class="size">{$size}</span>M，时长：<span class="time">{$leng}</span>
            </div>
            
HHH;
        echo $html;

    }
    public function play($id){
        $this->assign('id',$id);
        $data = ssl_decode($id);
        if(!empty($data)){
            $uinfo = Db::table('tbl_buy_time')->where(['ip'=>ip(),'uid'=>$data['u']])->find();
            if(!empty($uinfo) && $uinfo['endtime'] - time() >0){
                $uid = $uinfo['uid'];
            }
        }
        $oinfo = Db::table('tbl_order')->where(['ordersn'=>$id])->field('uid')->find();
        if(!empty($oinfo)){
            $uid = $oinfo['uid'];
        }
        if(empty($uid)){
            NOT_404();
        }
        $vid = Db::table('tbl_user')->where(['id'=>$uid])->value('vid');
        $this->assign('c','all');
        $this->assign('vid',$vid%2);
        $this->assign('uid',ssl_encode(['u'=>$uid]));
        $this->assign('hurl','/d/'.ssl_encode(['u'=>$uid]));
        if($vid == 5){
            return view('play5');
        }
        return view();
    }
    public function doplay(){
        $id = input('id');
        $ip = ip();
        $data = ssl_decode($id);
        $vid = '';
        $uid = '';
        if(!empty($data)){
            $uinfo = Db::table('tbl_buy_time')->where(['ip'=>ip(),'uid'=>$data['u']])->find();
            if(!empty($uinfo) && $uinfo['endtime'] - time() >0){
                $vid = $data['i'];
                $uid = $data['u'];
            }
        }else{
            $oinfo = Db::table('tbl_order')->where(['buyid'=>$ip,'ordersn'=>$id,'status'=>['in',[2,3]]])->field('id,vid,uid')->find();
            if(empty($oinfo)){
                return returnerror('此视频未购买');
            }
            $vid = $oinfo['vid'];
            $uid = $oinfo['uid'];
        }
        $vinfo = Db::table('tbl_video')->where(['id'=>$vid])->field('title,url')->find();
        if(empty($vinfo)){
            return returnerror('无效视频');
        }
        return returnsuccess($vinfo);
    }

    public function tousu(){
        Session::set('callbackurl',$_SERVER['HTTP_REFERER']);
        return view();
    }

    public function tousu2(){
        return view();
    }

    public function tousu3(){
        $callbackurl = Session::get('callbackurl');
        $this->assign('callbackurl',$callbackurl);
        return view();
    }
}