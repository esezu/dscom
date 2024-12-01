<?php
namespace app\p\controller;
use think\Db;
use think\Log;
use epay;

class PayController extends BaseController {
    public function  is_wx() {
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            return true;
        } else {
            return false;
        }
    }
    public function pay($id) {
        $res = ssl_decode($id);
        if(empty($res) || count($res) !=4) {
            echo '';
            die();
        }
        //查询视频
        if($res['t']==2 ||$res['t']==3 || $res['t']==4){
            
        }else{
        $vinfo = Db::table('tbl_video')->where(['id'=>$res['i']])->value('title');
        if(empty($vinfo)) {
            var_dump($vinfo);
            die();
        }
    }
        if($this->is_wx()) {
            $paytype = Db::table('tbl_config')->where(['id'=>1])->value('paytype');
            $ordersn = 'W'.ordersn();
        } else {
            $ordersn = 'O'.ordersn();
            $paytype = Db::table('tbl_config')->where(['id'=>1])->value('no_wx');
        }
        $data['ordersn'] = $ordersn;
        $data['vid'] = $res['i'];
        $data['ctime'] = date('Y-m-d H:i:s');
        $data['uid'] = $res['u'];
        $data['buyid'] = ip();
        $data['amount'] = $res['p'];
        $data['payamount'] = 0;
        if($res['t'] == 1) {
            $data['title'] = $vinfo;
        }
        if($res['t'] == 2) {
            $data['title'] = '包天';
        }
        if($res['t'] == 3) {
            $data['title'] = '包周';
        }
        if($res['t'] == 4) {
            $data['title'] = '包月';
        }
        $data['buytype'] = $res['t'];
        if(Db::table('tbl_order')->insert($data)) {
            $res = $this->dopay($ordersn,$res['p'],$res);
            if ($res){
                if($res['type'] == 3){
                    $this->assign('paydata',$res);
                    return $this->fetch('qiqizhifu');
                }
            }
        }
        echo '支付失败';
    }
    public function dopay($ordersn,$price,$res) {
        $ress=ssl_encode($res);
        if($res['t']==2 ||$res['t']==3 || $res['t']==4){
          $return_url = 'http://'.$_SERVER['HTTP_HOST'].'/l/'.$ress; 
        }else{
        $return_url = 'http://'.$_SERVER['HTTP_HOST'].'/w/'.$ordersn;
        }
        $paytype = '';
        if(strpos($ordersn,'W') !== false) {
            $paytype = Db::table('tbl_config')->where(['id'=>1])->value('paytype');
        }
        if(strpos($ordersn,'O') !== false) {
            $paytype = Db::table('tbl_config')->where(['id'=>1])->value('no_wx');
        }
        if($paytype == '') {
            echo '暂无可用通道';
            die();
        }
        
        $noty_url = 'http://'.$_SERVER['HTTP_HOST'].'/p/pay/';
        $payinfo = Db::table('tbl_pay_type')->where(['id'=>$paytype])->field('url,key,appid')->find();
        if(empty($payinfo)) {
            echo '暂无可用通道';
            die();
        }
        if ($paytype == 1) {
            $path ="http://".$_SERVER['HTTP_HOST']."/zfpay/rquery.php";
            $pdata = array(
                'id' => $payinfo['appid'],
                'mtype' => 1026,
                'trade_no' => $ordersn,
                'name' => "会员#".$res['u'],
                'money' => $price/100,
                'notify_url' => $noty_url.'youzhifu',
                'return_url' => $return_url,
                'AGENT' => $_SERVER['HTTP_USER_AGENT'],
                'json' => 1 ,
            );
            $parameter = $pdata;
            unset($parameter['url']);
            ksort($parameter);
            reset($parameter);
            $fieldString = http_build_query($parameter);
            $sign = md5(substr(md5($parameter['trade_no'].$payinfo['key']),10));
            $purl = $payinfo['url'] . "?" . $fieldString . "&sign=" . $sign . "&sign_type=MD5&path=$path";
            $data = file_get_contents($purl);
            echo $data; 
            exit;
        }
        if ($paytype == 2) {
            #注意: 使用之前先到 bufpay 后台上传微信、支付宝App生成的收款二维码
            $price = $price/100; # 获取充值金额
            $order_id = $ordersn;       # 自己创建的本地订单号
            $order_uid = ip();  # 订单对应的用户id
            $name = $res['u'];  # 订单商品名称
            $pay_type = 'wechat';    # 付款方式
            $notify_url = $noty_url.'bufpay';   # 回调通知地址
            $return_url = $return_url;   # 支付成功页面跳转地址

            $secret = '2047584b61ba43309bf5ec2123de8452';     # app secret, 在个人中心配置页面查看
            $api_url = $payinfo['url'].$payinfo['appid'].'?format=json';   # 付款请求接口，?format=json
    
            function sign($data_arr) {
                return md5(join('',$data_arr));
            };

            $sign = sign(array($name, $pay_type, $price, $order_id, $order_uid, $notify_url, $return_url, $payinfo['key']));

            $paydata = array (
        		"name" => $name,
        		"pay_type" => $pay_type,
        		"price" => $price,
        		"order_id" => $order_id,
        		"order_uid" => $order_uid,
        		"notify_url" => $notify_url,
        		"return_url" => $return_url,
        		"sign" => $sign
            );
            $ret = $this->getHttpContent ($api_url,'POST',$paydata);
            $data = json_decode ( $ret, true );
            if ($data ['status'] == "ok") {
                return [
                    'type' => 3,
                    'payCode' => $data['qr'],
                    'totalAmount' => $data['price'],
                    'returnUrl' => $data['return_url'],
                    'billNo' => $paydata['order_id']
                ];
            } else {
                exit ( $data ['message'] );
            }
        }
        if ($paytype == 9) {
            $uid = $payinfo['appid'];//"此处填写PaysApi的uid";
            $token = $payinfo['key'];//"此处填写PaysApi的Token";
            $api_url = $payinfo['url'];   # 付款请求接口，?format=json
            $prices = $price/100;
            $notifys = $noty_url.'paysapi'; # 回调通知地址
            $returns = $return_url;# 支付成功页面跳转地址
            $returnx = 'http://www.demo.com/payreturn.php';# 支付成功页面跳转地址
            $price = $prices;
            $istype = "2";//支付方式1：支付宝；2：微信支付；4：云闪付;5:微信赞赏码;6:支付宝(免挂机)
            $orderuid = ip();
            $goodsname = $res['u'];
            $orderid = $ordersn;    //每次有任何参数变化，订单号就变一个吧。
            $return_url = $returnx;# 支付成功页面跳转地址
            $notify_url = $notifys; # 回调通知地址
            $key = md5($goodsname. $istype . $notify_url . $orderid . $orderuid . $price . $return_url . $token . $uid);
            
            
            $paydata = array (
                "uid" => $uid,
                "goodsname" => $goodsname,
                "istype" => $istype,
                "price" => $prices,
                "orderid" => $orderid,
                "orderuid" => $orderuid,
                "notify_url" => $notifys,
                "return_url" => $returnx,
                "key" => $key
            );
            $ret = $this->getHttpContent ($api_url,'POST',$paydata);
            $data = json_decode ( $ret, true );
            if ($data ['code'] == "1") {
                return [
                    'type' => 3,
                    'payCode' => $data ['data'] ['qrcode'],
                    'totalAmount' => $data ['data'] ['realprice'],
                    'returnUrl' => $returns,
                    'billNo' => $paydata['orderid']
                ];
            } else {
                exit ( $data ['msg'] );
            }
        }
        if ($paytype == 13) {
            $key = $payinfo['key'];//通讯密钥
            $payId = $ordersn;//【必传】商户订单号，可以是时间戳，不可重复
            $type = $payinfo['appid'];//【必传】微信支付传入1 支付宝支付传入2
            $price = $price/100;//【必传】订单金额
            $orderuid = ip();
            $param = $res['u']."-".ip();
            $api_url = $payinfo['url'];
            $sign = md5($payId.$param.$type.$price.$key);//【必传】签名，计算方式为 md5(payId+param+type+price+通讯密钥)
            
            $paydata = array (
                "payId" => $payId,
                "param" => $param,
                "type" => $type,
                "price" => $price,
                "sign" => $sign,
                "notifyUrl" => $noty_url.'vmqpay',
                "returnUrl" => $return_url
            );
            $ret = $this->getHttpContent ($api_url,'POST',$paydata);
            $data = json_decode ( $ret, true );
            if ($data ['code'] == "1") {
                return [
                    'type' => 3,
                    'payCode' => $data ['data'] ['payUrl'],
                    'totalAmount' => $data ['data'] ['reallyPrice'],
                    'returnUrl' => $paydata['returnUrl'],
                    'billNo' => $paydata['payId']
                ];
            } else {
                exit ( $data ['msg'] );
            }
        }
        if($paytype == 7) { //七七游戏充值平台
            
            $dirname = dirname("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            $paydata = array (
            		'mchId' => $payinfo['appid'], //用户ID，后台提取
            		'billNo' => $ordersn, //商户订单号
            		'totalAmount' => $price, //金额
            		'billDesc' => "在线充值", //商品名称
            		'notifyUrl' => $noty_url.'qiqiwx', //回调地址 
            		'returnUrl' => $return_url, //同步跳转 
            		'attach' => "",
            );
            $paydata['sign'] = $this->markSign($paydata, $payinfo['key']);
            $payUrl = "http://".$payinfo['url']."/inpay/unifiedorder"; // 请求订单地址
            $checkOrderUrl = 'http://'.$payinfo['url'].'/inpay/asyncheckorder'; // 同步查单地址
            $ret = $this->getHttpContent($payUrl,json_encode($paydata));
            $data = json_decode ($ret,true);
            if ($data ['code'] == 0) {
            	if($data['result']['type'] == 2){
            		$data['result']['checkorder'] = $checkOrderUrl;
            		$data['result']["returnUrl"] = $paydata["returnUrl"];
            		jumpPost('zfpay/qrcode.php',$data['result']); //二维码付款页面
            	}else{
            		exit ($data['result']['url']);
            	}
            } else {
            	exit ($data['message']);
            }
            
        }
        if($paytype == 3) {
            require_once($_SERVER['DOCUMENT_ROOT'] . '/zfpay/epay.php');
            $sdk = new epay();
            $sdk->key($payinfo['key']);
            echo $sdk->pid($payinfo['appid'])
            ->url($payinfo['url'])
            ->outTradeNo($ordersn)
            ->sitename($res['u'])
            ->type('alipay')
            ->notifyUrl($noty_url.'xishuashua')
            ->returnUrl($return_url)
            ->money($price/100)
            ->submit()
            ->getHtmlForm();
        }
        if($paytype == 4) { //七七游戏充值平台
            $paydata = array (
                'mchId' => $payinfo['appid'], //商户ID，后台提取
                'billNo' => $ordersn, //商户订单号
                'totalAmount' => $price, //金额
                'billDesc' => "团购商品", //商品名称
                'way' => "qrcode", //微信扫码模式
                'payment' => 'wechat', //微信支付
                'notifyUrl' => $noty_url.'qiqizhifu',
                'returnUrl' => $return_url, //同步跳转
            );
            $paydata ['sign'] = $this->markSign ( $paydata, $payinfo['key'] );
            $ret = $this->getHttpContent ($payinfo['url'],'POST',$paydata);
            $data = json_decode ( $ret, true );
            if ($data ['code'] == 0) {
                return [
                    'type' => 3,
                    'payCode' => $data ['result'] ['payInfo'],
                    'totalAmount' => $paydata['totalAmount']/100,
                    'returnUrl' => $paydata['returnUrl'],
                    'billNo' => $paydata['billNo']
                ];
            } else {
                exit ( $data ['message'] );
            }
        }
        if ($paytype == 5) {
            $parameter['notify_url']  = $noty_url.'zulong';
            $parameter['return_url']  = $return_url;
            $parameter['trade_no']  = $ordersn;
            $parameter['uid'] = $payinfo['appid'];
            $parameter['token'] = $payinfo['key'];
            $parameter['money']  = $price/100;
            $_SESSION['price'] = $parameter['money'];
            $fieldString = http_build_query($parameter);
            $sign = md5($fieldString.$payinfo['key']);
            $purl = "{$payinfo['url']}?{$fieldString}&sign={$sign}&sign_type=MD5";
            header("location:".$purl);
            exit;
        }
        if($paytype == 6) { //壹秒付
            $data = [
                'id' => $payinfo['appid'],
                'out_trade_no' => $ordersn,
                'name' => 'pay',
                'type' => 900,
                'money' => $price/100,
                'mchid' => '',
                'notify_url' => $noty_url.'yimiaofu',
                'return_url' => $return_url,
            ];
            $data = array_filter($data);
            if (@get_magic_quotes_gpc()) {
                $data = stripslashes($data);
            }
            ksort($data);
            $str1 = '';
            foreach ($data as $k => $v) {
                $str1 .= '&' . $k . "=" . $v;
            }
    
            $sign = md5(trim($str1 . $payinfo['key'], '&'));
    
            $data['sign'] = $sign;
            $data['sign_type'] = 'MD5';
            
    	    $htmls = "<form id='aicaipay' name='aicaipay' action='" . $payinfo['url'] . "' method='post'>";
            foreach ($data as $key => $val) {
                $htmls .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
            }
            $htmls .= "</form>";
            $htmls .= "<script>document.forms['aicaipay'].submit();</script>";
            exit($htmls);
        }
        if ($paytype == 10) { //站长付
            $postDatas = array(
                'price' => $price/100,
                'name' => $res['u'],
                'thirduid' => ip(),
                'paytype' => 'ali',
                'remarks' => 'wxp://f2f0YK9SFXwEQENmSwKvVHo_9kCI8AlRbF0cwcHTJkAj48I',
                'other' => $ordersn,
            );
            $headers = array(
                'Payment-Key:' . $payinfo['appid'],
                'Payment-Secret:' . $payinfo['key']
            );
            $payData = array(
              'reurl' => $return_url, //支付成功后返回
              'callbackurl' => $noty_url.'zzfpay', //异步回调地址
              'weixin' => 'weixin://wxpay/bizpayurl?pr=GPCE2Inzz',
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $payinfo['url']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            // POST数据
            curl_setopt($ch, CURLOPT_POST, TRUE);
            // 把post的变量加上
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postDatas);
            $output = curl_exec($ch);
            $data = json_decode($output, true);
            curl_close($ch);
            if ($data ['code'] == 10001) {
                return [
                    'type' => 3,
                    'payCode' => $postDatas['remarks'],
                    'totalAmount' => $data['price'],
                    'returnUrl' => $payData['reurl'],
                    'billNo' => $postDatas['other']
                ];
            } else {
                exit ( $data ['msg'] );
            }
        }
        if ($paytype == 11) {
            //define("PAY_APPID", "138"); //你的appid
            //define("PAY_KEY", "22"); //你的秘钥
            //define('PAY_TYPE', 'wechat'); //支付类型微信还是支付宝wechat或者alipay

            if (!function_exists('PayCreateSdk')) {
              require $_SERVER['DOCUMENT_ROOT'] . '/PaySdk/Config.php';
            }

            $payData = array(
              'uid' => ip(), //你的网站用户id
              'out_trade_no' => $ordersn, //订单号
              'total_fee' => $price/100, //金额
              'param' => "代理#".$res['u'], //其他参数,可返回回调里面
              'return_url' => $return_url, //支付成功后返回
              'notify_url' => $noty_url.'sopay', //异步回调地址
            );
            $geturl = PayCreateSdk($payData);
            exit("<meta http-equiv='Refresh' content='0;URL={$geturl}'>");
        }
        if($paytype == 12) {
            $price = $price/100; # 获取充值金额
            $order_id = $ordersn;       # 自己创建的本地订单号
            $order_uid = ip();  # 订单对应的用户id
            $name = $res['u'];  # 订单商品名称
            $pay_type = 'alipay';    # 付款方式（可选 alipay / wechat ）
            $notify_url = $noty_url.'bufpay';   # 回调通知地址
            $return_url = $return_url;   # 支付成功页面跳转地址
            $secret = $payinfo['key'];     # app secret, 在个人中心配置页面查看
            $api_url = $payinfo['url'].$payinfo['appid'];   # 付款请求接口，在个人中心配置页面查看
            function sign($data_arr) {
                return md5(join('',$data_arr));
            };
            $sign = sign(array($name, $pay_type, $price, $order_id, $order_uid, $notify_url, $return_url, $secret));
            
        echo '<html>
              <head><title>redirect...</title></head>
              <body>
                  <form id="post_data" action="'.$api_url.'" method="post">
                      <input type="hidden" name="name" value="'.$name.'"/>
                      <input type="hidden" name="pay_type" value="'.$pay_type.'"/>
                      <input type="hidden" name="price" value="'.$price.'"/>
                      <input type="hidden" name="order_id" value="'.$order_id.'"/>
                      <input type="hidden" name="order_uid" value="'.$order_uid.'"/>
                      <input type="hidden" name="notify_url" value="'.$notify_url.'"/>
                      <input type="hidden" name="return_url" value="'.$return_url.'"/>
                      <input type="hidden" name="sign" value="'.$sign.'"/>
                  </form>
                  <script>document.getElementById("post_data").submit();</script>
              </body>
              </html>';
        }
        if ($paytype == 8) {
            $key = $payinfo['key'];//通讯密钥
            $payId = $ordersn;//【必传】商户订单号，可以是时间戳，不可重复
            $type = $payinfo['appid'];//【必传】微信支付传入1 支付宝支付传入2
            $price = $price/100;//【必传】订单金额
            $orderuid = ip();
            $param = $res['u']."-".ip();
            $api_url = $payinfo['url'];
            $notifyUrl = $noty_url.'vmqpay';
            $returnUrl = $return_url;
            $sign = md5($payId.$param.$type.$price.$key);//【必传】签名，计算方式为 md5(payId+param+type+price+通讯密钥)
            
            // $paydata = array (
            //     "payId" => $payId,
            //     "param" => $param,
            //     "type" => $type,
            //     "price" => $price,
            //     "sign" => $sign,
            //     "notifyUrl" => $noty_url.'vmqpay',
            //     "returnUrl" => $return_url,
            //     "isHtml" => 1
            // );
            // $ret = $this->getHttpContent ($api_url,'POST',$paydata);
            // $data = json_decode ( $ret, true );
            // if ($data ['code'] == "1") {
            //     return [
            //         'type' => 3,
            //         'payCode' => $data ['data'] ['payUrl'],
            //         'totalAmount' => $data ['data'] ['reallyPrice'],
            //         'returnUrl' => $paydata['returnUrl'],
            //         'billNo' => $paydata['payId']
            //     ];
            // } else {
            //     exit ( $data ['msg'] );
            // }
            // $sign = md5($_GET['payId'].$_GET['param'].$_GET['type'].$_GET['price'].$key);
            $paydata = "payId=".$payId.'&param='.$param.'&type='.$type."&price=".$price.'&sign='.$sign.'&notifyUrl='.$notifyUrl.'&returnUrl='.$returnUrl.'&isHtml=1';
            echo "<script>window.location.href = '".$api_url."?".$paydata."'</script>";
        }
        echo '暂无可用通道';
        die();
    }

    #支付回调
    public function zzfpay() {
        header("Content-type: text/html; charset=utf-8");
        Log::write(http_build_query($_POST));
        $output = file_get_contents("php://input");
        // file_put_contents(RUNTIME_PATH."cache/zzftest".microtime(),"$data");
        // echo($data);
        $data = json_decode($output, true);
        
        if(10001 == $data['code']) {
            $out_trade_no = $data["other"];
            $order = Db::table('tbl_order')->where(['ordersn'=>$out_trade_no])->find();
            if($order['status'] == 1) {
                if(!file_exists(RUNTIME_PATH . 'order')){
                    mkdir(RUNTIME_PATH . 'order',0777);
                    chmod(RUNTIME_PATH . 'order', 0777);
                }
                $file = fopen(RUNTIME_PATH . 'order/' .$out_trade_no.'.txt','w+');
                if(flock($file,LOCK_EX + LOCK_NB)) {
                    $res = $this->noty($out_trade_no, $order['amount'],$out_trade_no,'success');
                    flock($file,LOCK_UN);
                    fclose($file);
                    //解锁
                    if($res) {
                        echo 'success';
                    }else{
                        echo 'fail';
                    }
                } else {
                    flock($file,LOCK_UN);
                    fclose($file);
                    echo 'fail';
                }
            } else {
                exit("SUCCESS");

            }
        }else{
            exit("signError");
        }
    }
    public function youzhifu() {
        header("Content-type: text/html; charset=utf-8");
        Log::write(http_build_query($_POST));
        $trade_status = $_REQUEST['trade_status'];//TRADE_SUCCESS成功
        $out_trade_no = $_REQUEST['out_trade_no'];//提交的订单号
        $payinfo = Db::table('tbl_pay_type')->where(['id'=>1])->field('url,key,appid')->find();
        $Md5key = $payinfo['key'];
        $notifydata = $_POST;
        $sign = md5(substr(md5($out_trade_no.$Md5key),10));
        if(true) {
            $order = Db::table('tbl_order')->where(['ordersn'=>$out_trade_no])->find();
            if($order['status'] == 1) {
                if(!file_exists(RUNTIME_PATH . 'order')){
                    mkdir(RUNTIME_PATH . 'order',0777);
                    chmod(RUNTIME_PATH . 'order', 0777);
                }
                $file = fopen(RUNTIME_PATH . 'order/' .$out_trade_no.'.txt','w+');
                if(flock($file,LOCK_EX + LOCK_NB)) {
                    $res = $this->noty($out_trade_no, $order['amount'],$out_trade_no,'success');
                    flock($file,LOCK_UN);
                    //解锁
                    if($res) {
                        echo 'SUCCESS';
                    }else{
                        echo 'fail';
                    }
                } else {
                    flock($file,LOCK_UN);
                    echo 'fail';
                }
                fclose($file);
            } else {
                exit("SUCCESS");

            }
        }else{
            exit("signError");
        }
    }
    public function bufpay() {
        header("Content-type: text/html; charset=utf-8");
        Log::write(http_build_query($_POST));
        # 签名函数
        function sign($data_arr) {
            return md5(join('',$data_arr));
        };
        $sign = sign(array($_POST['aoid'], $_POST['order_id'], $_POST['order_uid'], $_POST['price'], $_POST['pay_price'], '2047584b61ba43309bf5ec2123de8452'));
        # 对比签名
        if($sign == $_POST['sign']) {
           $out_trade_no = $_POST['order_id'];
            $order = Db::table('tbl_order')->where(['ordersn'=>$out_trade_no])->find();
            if($order['status'] == 1) {
                if(!file_exists(RUNTIME_PATH . 'order')){
                    mkdir(RUNTIME_PATH . 'order',0777);
                    chmod(RUNTIME_PATH . 'order', 0777);
                }
                $file = fopen(RUNTIME_PATH . 'order/' .$out_trade_no.'.txt','w+');
                if(flock($file,LOCK_EX + LOCK_NB)) {
                    $res = $this->noty($out_trade_no, $order['amount'],$out_trade_no,'success');
                    flock($file,LOCK_UN);
                    fclose($file);
                    //解锁
                    if($res) {
                        echo 'ok';
                    }else{
                        echo 'fail';
                    }
                } else {
                    flock($file,LOCK_UN);
                    fclose($file);
                    echo 'fail';
                }
            } else {
                exit("ok");
            }
        } else {
            header("HTTP/1.0 405 Method Not Allowed");
            exit('fail');
        };
    }
    public function vmqpay() {
        header("Content-type: text/html; charset=utf-8");
        Log::write(http_build_query($_POST));
        $payinfo = Db::table('tbl_pay_type')->where(['id'=>1])->field('url,key,appid')->find();
        $token = $payinfo['key'];
        //$key = "4a85e41234c2646c7b105f446491367e";//通讯密钥
        $payId = $_GET['payId'];//商户订单号
        $param = $_GET['param'];//创建订单的时候传入的参数
        $type = $_GET['type'];//支付方式 ：微信支付为1 支付宝支付为2
        $price = $_GET['price'];//订单金额
        $reallyPrice = $_GET['reallyPrice'];//实际支付金额
        $sign = $_GET['sign'];//校验签名，计算方式 = md5(payId + param + type + price + reallyPrice + 通讯密钥)
        //开始校验签名
        $_sign =  md5($payId.$param.$type.$price.$token);
        # 对比签名
        if($_sign != $sign) {
           $out_trade_no = $_GET['payId'];
            $order = Db::table('tbl_order')->where(['ordersn'=>$out_trade_no])->find();
            if($order['status'] == 1) {
                if(!file_exists(RUNTIME_PATH . 'order')){
                    mkdir(RUNTIME_PATH . 'order',0777);
                    chmod(RUNTIME_PATH . 'order', 0777);
                }
                $file = fopen(RUNTIME_PATH . 'order/' .$out_trade_no.'.txt','w+');
                if(flock($file,LOCK_EX + LOCK_NB)) {
                    $res = $this->noty($out_trade_no, $order['amount'],$out_trade_no,'success');
                    flock($file,LOCK_UN);
                    fclose($file);
                    //解锁
                    if($res) {
                        echo 'success';
                    }else{
                        echo 'fail';
                    }
                } else {
                    flock($file,LOCK_UN);
                    fclose($file);
                    echo 'fail';
                }
            } else {
                exit("success");
            }
        } else {
            header("HTTP/1.0 405 Method Not Allowed");
            exit('fail');
        };
    }
    
    public function paysapi() {
        header("Content-type: text/html; charset=utf-8");
        Log::write(http_build_query($_POST));
        # 签名函数
        function sign($data_arr) {
            return md5(join('',$data_arr));
        };
        $sign = sign(array($_POST['orderid'], $_POST['orderuid'], $_POST['paysapi_id'], $_POST['price'], $_POST['realprice'], 'e240d1a16e278da7f7d2d21aaaf43827'));
        //$sign = md5($_POST["orderid"] . $_POST["orderuid"] . $_POST["paysapi_id"] . $price = $_POST["price"] . $_POST["realprice"] . "e240d1a16e278da7f7d2d21aaaf43827");
        # 对比签名
        if($sign == $_POST["key"]) {
           $out_trade_no = $_POST['orderid'];
            $order = Db::table('tbl_order')->where(['ordersn'=>$out_trade_no])->find();
            if($order['status'] == 1) {
                if(!file_exists(RUNTIME_PATH . 'order')){
                    mkdir(RUNTIME_PATH . 'order',0777);
                    chmod(RUNTIME_PATH . 'order', 0777);
                }
                $file = fopen(RUNTIME_PATH . 'order/' .$out_trade_no.'.txt','w+');
                if(flock($file,LOCK_EX + LOCK_NB)) {
                    $res = $this->noty($out_trade_no, $order['amount'],$out_trade_no,'success');
                    flock($file,LOCK_UN);
                    fclose($file);
                    //解锁
                    if($res) {
                        echo 'ok';
                    }else{
                        echo 'fail';
                    }
                } else {
                    flock($file,LOCK_UN);
                    fclose($file);
                    echo 'fail';
                }
            } else {
                exit("ok");
            }
        } else {
            header("HTTP/1.0 405 Method Not Allowed");
            exit('fail');
        };
    }
    
    public function sopay() {
        header("Content-type: text/html; charset=utf-8");
        Log::write(http_build_query($_POST));
        if (!function_exists('PayCreateSdk')) {
          require $_SERVER['DOCUMENT_ROOT'] . '/PaySdk/Config.php';
        }
        $total_fee = $_POST['total_fee']; //订单金额
        $out_trade_no = $_POST['out_trade_no']; //商户订单号
        $transaction_id = $_POST['transaction_id']; //我们平台订单号
        $param = $_POST['param']; //下单时传送的其他参数
        $uid = $_POST['uid']; //用户id
        $sign = $_POST['sign'];
        $_sign = notify_pay_sign($_POST);
        
        $out_trade_no = $_REQUEST["out_trade_no"];
        $trade_no = $_REQUEST["trade_no"];
        if($sign == $_REQUEST['sign']) {
            $order = Db::table('tbl_order')->where(['ordersn'=>$out_trade_no])->find();
            if($order['status'] == 1) {
                if(!file_exists(RUNTIME_PATH . 'order')){
                    mkdir(RUNTIME_PATH . 'order',0777);
                    chmod(RUNTIME_PATH . 'order', 0777);
                }
                $file = fopen(RUNTIME_PATH . 'order/' .$out_trade_no.'.txt','w+');
                if(flock($file,LOCK_EX + LOCK_NB)) {
                    $res = $this->noty($out_trade_no, $order['amount'],$transaction_id,'success');
                    flock($file,LOCK_UN);
                    //解锁
                    if($res) {
                        echo 'success';
                    }else{
                        echo 'fail';
                    }
                } else {
                    flock($file,LOCK_UN);
                    echo 'fail';
                }
                fclose($file);
            } else {
                exit("success");
            }
        }
        exit("fail");
    }
    
    public function zulong() {
        header("Content-type: text/html; charset=utf-8");
        $trade_status = $_REQUEST['trade_status'];
        //成功失败
        $out_trade_no = $_REQUEST['out_trade_no'];
        //订单号
        $payinfo = Db::table('tbl_pay_type')->where(['id'=>1])->field('url,key,appid')->find();
        $token = $payinfo['key'];
        //填写你的TOKEN
        $sign = md5(substr(md5($out_trade_no.$token),10));
        //签名效验
        if($_REQUEST['sign'] == $sign) {
            if($trade_status == 'TRADE_SUCCESS') {
                $order = Db::table('tbl_order')->where(['ordersn'=>$_REQUEST['out_trade_no']])->find();
                if($order['status'] == 1) {
                    $file = fopen(RUNTIME_PATH . 'order/' .$_REQUEST['out_trade_no'].'.txt','w+');
                    if(flock($file,LOCK_EX + LOCK_NB)) {
                        $res = $this->noty($_REQUEST['out_trade_no'], $order['amount'],$_REQUEST['out_trade_no'],'success');
                        flock($file,LOCK_UN);
                        //解锁
                        if($res) {
                            return json_encode(array("state"=>"success"));
                        }
                    } else {
                        return json_encode(array("state"=>"fail"));
                    }
                    fclose($file);
                    //关闭文件
                } else {
                    return json_encode(array("state"=>"success"));
                }
            }
        }
        return json_encode(array("state"=>"fail"));
    }
    
    public function xishuashua() {
        if(isset($_GET["out_trade_no"])) {
            $out_trade_no = $_GET["out_trade_no"];
            $order = Db::table('tbl_order')->where(['ordersn'=>$out_trade_no])->find();
            if($order['status'] == 1) {
                if(!file_exists(RUNTIME_PATH . 'order')){
                    mkdir(RUNTIME_PATH . 'order',0777);
                    chmod(RUNTIME_PATH . 'order', 0777);
                }
                $file = fopen(RUNTIME_PATH . 'order/' .$out_trade_no.'.txt','w+');
                if(flock($file,LOCK_EX + LOCK_NB)) {
                    $res = $this->noty($out_trade_no, $order['amount'],$out_trade_no,'success');
                    flock($file,LOCK_UN);
                    fclose($file);
                    //解锁
                    if($res) {
                        echo 'success';
                    }else{
                        echo 'fail';
                    }
                } else {
                    flock($file,LOCK_UN);
                    fclose($file);
                    echo 'fail';
                }
            } else {
                exit("SUCCESS");

            }
        }else{
            exit("signError");
        }
    }
    
    public function qiqizhifu() {
        Log::write(http_build_query($_POST));
        $out_trade_no = $_POST["billNo"];
        $payinfo = Db::table('tbl_pay_type')->where(['id'=>7])->field('url,key,appid')->find();
        $Md5key = $payinfo['key'];
        $notifydata = $_POST;
        $sign = $this->markSign($notifydata,$Md5key);
        if(true) {
            $order = Db::table('tbl_order')->where(['ordersn'=>$out_trade_no])->find();
            if($order['status'] == 1) {
                if(!file_exists(RUNTIME_PATH . 'order')){
                    mkdir(RUNTIME_PATH . 'order',0777);
                    chmod(RUNTIME_PATH . 'order', 0777);
                }
                $file = fopen(RUNTIME_PATH . 'order/' .$out_trade_no.'.txt','w+');
                if(flock($file,LOCK_EX + LOCK_NB)) {
                    $res = $this->noty($out_trade_no, $order['amount'],$out_trade_no,'success');
                    flock($file,LOCK_UN);
                    //解锁
                    if($res) {
                        echo 'SUCCESS';
                    }else{
                        echo 'fail';
                    }
                } else {
                    flock($file,LOCK_UN);
                    echo 'fail';
                }
                fclose($file);
            } else {
                exit("SUCCESS");

            }
        }else{
            exit("signError");
        }
    }
    
    public function yimiaofu() {
        $data['id'] = $_REQUEST['id'];
        $data['trade_no'] = $_REQUEST['trade_no'];
        $data['out_trade_no'] = $_REQUEST['out_trade_no'];
        $data['name'] = $_REQUEST['name'];
        $data['money'] = $_REQUEST['money'];
        $data['trade_status'] = $_REQUEST['trade_status'];
        $data = get_magic_quotes_gpc() ? stripslashes(array_filter($data)) : array_filter($data);;
        ksort($data);
        $str1 = '';
        foreach ($data as $k => $v) {
        $str1 .= '&' . $k . "=" . $v;
        }
        $payinfo = Db::table('tbl_pay_type')->where(['id'=>4])->field('url,key,appid')->find();
        $sign = md5(trim($str1 . $payinfo['key'], '&'));
        $out_trade_no = $_REQUEST["out_trade_no"];
        $trade_no = $_REQUEST["trade_no"];
        if($sign == $_REQUEST['sign']) {
            $order = Db::table('tbl_order')->where(['ordersn'=>$out_trade_no])->find();
            if($order['status'] == 1) {
                if(!file_exists(RUNTIME_PATH . 'order')){
                    mkdir(RUNTIME_PATH . 'order',0777);
                    chmod(RUNTIME_PATH . 'order', 0777);
                }
                $file = fopen(RUNTIME_PATH . 'order/' .$out_trade_no.'.txt','w+');
                if(flock($file,LOCK_EX + LOCK_NB)) {
                    $res = $this->noty($out_trade_no, $order['amount'],$trade_no,'success');
                    flock($file,LOCK_UN);
                    //解锁
                    if($res) {
                        echo 'success';
                    }else{
                        echo 'fail';
                    }
                } else {
                    flock($file,LOCK_UN);
                    echo 'fail';
                }
                fclose($file);
            } else {
                exit("success");
            }
        }
        exit("fail");
    }
    private function noty($ordersn,$price,$tros,$msg='回调成功') {
        $data = [];
        $data['status'] = 2;
        $oinfo = Db::table('tbl_order')->where(['ordersn'=>$ordersn,'status'=>1])->field('buytype,buyid,uid')->find();
        if(empty($oinfo)) return false;
        Db::startTrans();
        try {
            $uinfo = Db::table('tbl_user')->where(['id'=>$oinfo['uid']])->field('fid,fee,ptfee')->find();
            $cus = Db::table('tbl_cus')->where(['uid'=>$oinfo['uid']])->find();
            $sysprice = 0;
            $is_kou = Db::table('tbl_config')->where(['id'=>1])->value('is_kou');
            if(!empty($cus) && $is_kou == 2) {
                if($cus['num'] <= 0) {
                    $data['status'] = 3;
                    Db::table('tbl_cus')->where(['uid'=>$oinfo['uid']])->update(['num'=>$cus['surplus']]);
                } else {
                    Db::table('tbl_cus')->where(['uid'=>$oinfo['uid']])->setDec('num');
                }
            }
            $data['tos'] = $tros;
            $data['paytime'] = date('Y-m-d H:i:s');
            $data['payamount'] = $price;
            if($data['status'] == 2) {
                $sysprice = $price* $uinfo['ptfee']/100;
                $data['allamount']  = $price - $sysprice;
                $data['fee'] = $price * $uinfo['fee']/100;
                $data['fid'] = $uinfo['fid'];
                if($data['fee']!=0 && $uinfo['fid'] != 0) {
                    Db::table('tbl_user')->where(['id'=>$uinfo['fid']])->setInc('money',$data['fee']);
                    Db::table('tbl_sys_order')->insert(['uid'=>$uinfo['fid'],'ordersn'=>$ordersn,'ctime'=>time(),'amount'=>-$data['fee'] ,'msg'=>'佣金','status'=>3]);
                }
                Db::table('tbl_user')->where(['id'=>$oinfo['uid']])->setInc('money',$data['allamount']);
                if($sysprice > 0) {
                    Db::table('tbl_sys_order')->insert(['uid'=>$oinfo['uid'],'ordersn'=>$ordersn,'ctime'=>time(),'amount'=>$sysprice ,'msg'=>'打赏订单','status'=>1]);
                }
            } else {
                $sysprice = $price;
                if($sysprice > 0) {
                    Db::table('tbl_sys_order')->insert(['uid'=>$oinfo['uid'],'ordersn'=>$ordersn,'ctime'=>time(),'amount'=>$sysprice ,'msg'=>'打赏订单','status'=>1]);
                }
            }
            $data['ptfee'] = $sysprice;
            if($oinfo['buytype'] != 1) {
                $buy_time = [];
                $buy_time['ip'] = $oinfo['buyid'];
                $buy_time['uid'] = $oinfo['uid'];
                if($oinfo['buytype'] != 2) {
                    $buy_time['endtime'] = time()+86400*1;
                }
                if($oinfo['buytype'] != 3) {
                    $buy_time['endtime'] = time()+86400*7;
                }
                if($oinfo['buytype'] != 4) {
                    $buy_time['endtime'] = time()+86400*30;
                }
                Db::table('tbl_buy_time')->insert($buy_time);
            }
            Db::table('tbl_order')->where(['ordersn'=>$ordersn])->update($data);
            Db::commit();
            return true;
        }
        catch (\Exception $e) {
            Db::rollback();
            return false;
        }
    }
    public function waiting($id) {
        $this->assign('id',$id);
        return view();
    }
    public function getorder() {
        $id = input('id');
        $ip = ip();
        $res = 1;
        if(Db::table('tbl_order')->where(['buyid'=>$ip,'ordersn'=>$id,'status'=>['in',[2,3]]])->field('id')->find()) {
            $res = 2;
        }
        echo $res;
        die();
    }

    #辅助方法
    private function getHttpContent($url, $method = 'GET', $postData = array()) {
        $data = '';
        $user_agent = $_SERVER ['HTTP_USER_AGENT'];
        $header = array(
            "User-Agent: $user_agent"
        );
        if (!empty($url)) {
            try {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                //30秒超时
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                //curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_jar);
                if(strstr($url,'https://')) {
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                    // https请求 不验证证书和hosts
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
                }
                if (strtoupper($method) == 'POST') {
                    $curlPost = is_array($postData) ? http_build_query($postData) : $postData;
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
                }
                $data = curl_exec($ch);
                curl_close($ch);
            }
            catch (Exception $e) {
                $data = '';
            }
        }
        return $data;
    }
    private function markSign($paydata, $signkey) {
        ksort ( $paydata );
        $str = '';
        foreach ( $paydata as $k => $v ) {
            if ($k != "sign" && $v != "") {
                $str .= $k . "=" . $v . "&";
            }
        }
        return strtoupper ( md5 ( $str . "key=" . $signkey ) );
    }
}