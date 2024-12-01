<?php
namespace app\cn\controller;
use think\Cache;
use think\Controller;
use think\Db;

class BaseController extends Controller{
    protected function _initialize(){

        $note = [
            'home/login',
            'home/register'
        ];

        if( !in_array(strtolower(request()->controller().'/'.request()->action()),$note)){
            $this->permissions();
        }
    }

    protected function permissions(){
        if(empty(session('userid'))) {
            $this->redirect('home/login');
        }
    }
    public function curl_post($url,$data){
        $row_curl = curl_init();
        curl_setopt($row_curl, CURLOPT_URL, $url);
        curl_setopt($row_curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($row_curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($row_curl, CURLOPT_CONNECTTIMEOUT , 30);
        curl_setopt($row_curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($row_curl, CURLOPT_POST, 1);
        curl_setopt($row_curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($row_curl, CURLOPT_ENCODING, "gzip");
        curl_setopt($row_curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($row_curl);
        curl_close($row_curl);
        return $result;
    }
    public function getulr($type = '1',$id ='',$heziid=''){
        $uinfo = Db::table('tbl_user')->where(['id'=>session('userid')])->field('ename,kz')->find();//获取代理单个域名
        $datag = Db::table('tbl_ename_index')->where(['status'=>1])->limit(1)->orderRaw('rand()')->find();//随机获取入口域名
        $config = Db::table('tbl_config')->where(['id'=>1])->field('url,kz_url')->find();
        $sutz = substr(md5(time()), 0, 3);
        $data = [];
        $data['u'] = session('userid');
        $data['r'] = time();
        if($id){
            $data['v'] = $id;
        }
        if($heziid){
            $data['heziid'] = $heziid;
        }
        if($datag['ename'] == ''){
            echo '缺少入口域名';die();
        }
        $wxs = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx4c01aaf5e77a7bca&response_type=code&scope=snsapi_base&redirect_uri=";
        $url = "http://".$datag['ename'].'/d/'.ssl_encode($data).'/'.$sutz;
        if($type == 1){

            if($config['url'] == 1){
                $json=$url;
                    return $url;
            }
            if($config['url'] == 2){
                $json=file_get_contents("https://urlc.cn/api/?format=json&key=kUTsgtJhEo3g&url=".urlencode($url));
                $arr=json_decode($json,true);
                if(isset($arr['short'])){
                    return $arr['short'];
                }else{
                    return $url;
                }
            }
            if($config['url'] == 3){
                $json=file_get_contents("http://api.ft12.com/api.php?format=json&apikey=13712718624@f5824cd16e0cbdd37063ace852eb4147&url=".urlencode($url));
                $arr=json_decode($json,true);
                if(isset($arr['url'])){
                    return $arr['url'];
                }else{
                    return $url;
                }
            }
            if($config['url'] == 4){
                $json=file_get_contents("https://api.uouin.com/index.php/index/Userapi?username=2468218236&key=H3SHYmjGIpFLk9d&url=".urlencode($url));
                $arr=json_decode($json,true);
                if(isset($arr['short'])){
                    return $arr['short'];
                }else{
                    return $url;
                }
            }
            //备用短网址
            if($config['url'] == 5){
                $json=file_get_contents("https://api.uouin.com/app/tcn?username=2468218236&key=H3SHYmjGIpFLk9d&url=".urlencode($wxs.$url));
                $arr=json_decode($json,true);
                if(isset($arr['short'])){
                    return $arr['short'];
                }else{
                    return $url;
                }
            }
            if($config['url'] == 6){
                $json=file_get_contents("https://api.uouin.com/app/sinaurl?username=2468218236&key=H3SHYmjGIpFLk9d&url=".urlencode($wxs.$url));
                $arr=json_decode($json,true);
                if(isset($arr['short'])){
                    return $arr['short'];
                }else{
                    return $url;
                }
            }
            if($config['url'] == 7){
                $tou="http://m.toutiao.com/search/jump?url=";//申请地址 https://api.uouin.com/
                $json=file_get_contents("https://api.uouin.com/app/dwzjh?username=2468218236&key=H3SHYmjGIpFLk9d&dwztype=jmp&url=".urlencode($url));
                $arr=json_decode($json,true);
                if(isset($arr['short'])){
                    return $arr['short'];
                }else{
                    return $url;
                }
            }
            if($config['url'] == 8){
                $result = json_decode(file_get_contents('https://is.gd/create.php?format=json&url='.$url),true);
                if(isset($result['shorturl'])){
                    $url = $result['shorturl'];
                }
                return $url;
            }
            if($config['url'] == 9){
                $accessToken=$this->getAccessToken();
                $data = '{"action":"long2short","long_url":"'.$url.'"}';
                $shortUrl = "https://api.weixin.qq.com/cgi-bin/shorturl?access_token={$accessToken}";
                $shorurl = json_decode($this->getShort($data, $shortUrl),true) ;
                if(isset($shorurl['short_url'])){
                    $url = $shorurl['short_url'];
                }
                return $url;
            }
            if($config['url'] == 10){
                $list = Db::table('tbl_mpwx')->order('id desc')->select();
                if (!$list) $this->error('没有可用公众号信息');
                $mpwxkey = array_rand($list,1);
                $wx = $list[$mpwxkey];
                $access_token = Cache::get($wx['appid']);
                if (!$access_token){
                    $json = $this->getToken("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$wx['appid']."&secret=".$wx['appsecret']);
                    $arr=json_decode($json,true);
                    if(isset($arr['access_token'])){
                        $access_token = Cache::set($wx['appid'],$arr['access_token'],6800);
                    }else{
                        $this->error($arr['errmsg']);
                    }
                }
                $json = $this->getShort(json_encode(['access_token'=>$access_token,'action'=>'long2short','long_url'=>$url]),"https://api.weixin.qq.com/cgi-bin/shorturl?access_token=".$access_token);
                $arr=json_decode($json,true);
                if(isset($arr['short_url'])){
                    return $arr['short_url'];
                }else{
                    $this->error($arr['errmsg']);
                }
            }
        }
        if($type == 2){
            unset($data['r']);
            //$kuaizhan = Db::table('tbl_ename_index')->where(['status'=>2])->select();
            $kuaizhan = Db::table('tbl_ename_index')->where(['status'=>1])->limit(1)->orderRaw('rand()')->select();//随机获取入口域名
            $kzconfig = Db::table('tbl_config')->where(['id'=>1])->field('url,kz_url')->find();
            if($uinfo['kz'] != ''){
                $kzurl = "http://".$uinfo['kz'].'/d/'.ssl_encode($data).'/'.$sutz;
            }else{
                if (!$kuaizhan){
                    exit('缺少入口域名');
                }else{
                    $rand = array_rand($kuaizhan,1);
                    $kz_url = $kuaizhan[$rand]['ename'];
                    $kzurl = "http://".$kz_url.'/d/'.ssl_encode($data).'/'.$sutz;
                }
            }
            if($config['kz_url'] == 1){
                $json=$kzurl;
                return $kzurl;
            }
            if($config['url'] == 3){
                $token="1aeaba0a9e769583bc4cd06652d4628c";//申请地址 http://baofeng.la
                $json=file_get_contents("http://yy.go1n1gju.at/app/tturl11?token={$token}&long=".urlencode($kzurl));
                $arr=json_decode($json,true);
                return $arr['short'];
            }
            if($config['url'] == 4){
                $token="H3SHYmjGIpFLk9d";//申请地址 https://api.uouin.com/
                $json=file_get_contents("https://api.uouin.com/index.php/index/Userapi?username=2468218236&key=H3SHYmjGIpFLk9d&url=".urlencode($kzurl));
                $arr=json_decode($json,true);
                if(isset($arr['short'])){
                    return $arr['short'];
                }else{
                    return $url;
                }
            }
            if($config['url'] == 5){
                $list = Db::table('tbl_mpwx')->order('id desc')->select();
                if (!$list) $this->error('没有可用公众号信息');
                $mpwxkey = array_rand($list,1);
                $wx = $list[$mpwxkey];
                $access_token = Cache::get($wx['appid']);
                if (!$access_token){
                    $json = $this->getToken("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$wx['appid']."&secret=".$wx['appsecret']);
                    $arr=json_decode($json,true);
                    if(isset($arr['access_token'])){
                         $access_token = $arr['access_token'];
                         Cache::set($wx['appid'],$arr['access_token'],6800);
                    }else{
                        $this->error($arr['errmsg']);
                    }
                }
                $json = $this->getShort(json_encode(['access_token'=>$access_token,'action'=>'long2short','long_url'=>$kzurl]),"https://api.weixin.qq.com/cgi-bin/shorturl?access_token=".$access_token);
                $arr=json_decode($json,true);
                if(isset($arr['short_url'])){
                    return $arr['short_url'];
                }else{
                    $this->error($arr['errmsg']);
                }
                exit;
            }
        }
    }
    public function getulrlenth($id = '',$heziid=''){
        $ename = Db::table('tbl_user')->where(['id'=>session('userid')])->field('ename')->find();;
        $data = [];
        $data['u'] = session('userid');
        if($id){
            $data['v'] = $id;
        }
        if($heziid){
            $data['heziid'] = $heziid;
        }
        return 'http://'.$ename['ename'].'/d/'.ssl_encode($data);
    }
    public function getShort($data, $url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.22 (KHTML, like Gecko)");
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tmpInfo = curl_exec($ch);
        if (curl_errno($ch)){
            return curl_error($ch);
        }
        curl_close($ch);
        return $tmpInfo;
    }
    public function getAccessToken(){
        $acc = @file_get_contents('./accesstoken.txt');
        $accarr = json_decode($acc,true);
        if(!empty($accarr)){
            if(isset($accarr['time']) && $accarr['time'] > time()){
                return $accarr['access_token'];
            }
        }
        $appId = "";
        $appSecret = "";
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appId}&secret={$appSecret}";
        $output = $this->getToken($url);
        $token = json_decode($output,true);
        if(!isset($token['access_token'])){
            echo '获取accesstoken失败';die();
        }
        $accessToken = $token['access_token'];
        file_put_contents('./accesstoken.txt',json_encode(['access_token'=>$accessToken,'time'=>6000+time()]));
        return $accessToken;
    }
    public function getToken($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.22 (KHTML, like Gecko)");
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
}
