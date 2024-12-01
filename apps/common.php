<?php
function returnerror($msg, $code = 400){
	$returnData = array(
		'code' => $code,
		'msg' => $msg
	);
	return json($returnData);
}
function returnsuccess($msg, $code = 200,$data =[]){
	$returnData = array(
		'code' => $code,
		'msg' => $msg
	);
	if(!empty($data)){
		$returnData['data'] = $data;
	}
	return json($returnData);
}


//密码
function password($str){
	return strtoupper(md5($str.'%^&*()_'));
}


function returnlay($data = array(), $count = 0 ,$msg='获取成功'){
	$returnData = array(
		'code' => 0,
		'msg' => $msg,
		'count' => $count,
		'data' => $data
	);
	return json($returnData);
}
//是否是ajax请求
function is_ajax(){
	if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){
	   return true;
	}
	return false;
}
function vid($id = null){
	$data = [
	    5=>'无包天',
		4=>'新单列',
		3=>'新双列',
	];
	if($id){
		return $data[$id];
	}
	return $data;

}
//订单号
function ordersn(){
	return date('YmdHis').rand(1000,9999).strtoupper(uniqid());
}

function returnlaydate($msg, $data = array(), $count = 0 ){
	$returnData = array(
		'code' => 0,
		'msg' => $msg,
		'count' => $count,
		'data' => $data
	);
	return json($returnData);
}
function un_http_build_query($str){
	$http_str = base64_decode($str);
	$arr = explode('&', $http_str);
 	if(!is_array($arr)){
 		return null;
 	}
	$data = [];
	foreach($arr as $v){
		$one = [];
		$one = explode('=',$v);
		if(count($one) !=2){
			return null;
		}
		$data[$one[0]] = $one[1];
	}
	return $data;
}
function ip(){
    $ip = session('userip');
    if(!$ip){
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $ip = trim(current($ip));
        }
        if(!$ip){
            $ip =  $_SERVER['REMOTE_ADDR'];
        }
        if (!preg_match('/^((?:(?:25[0-5]|2[0-4]\d|((1\d{2})|([1-9]?\d)))\.){3}(?:25[0-5]|2[0-4]\d|((1\d{2})|([1 -9]?\d))))$/', $ip)) {
            $ip_long = array(
                array('607649792', '608174079'), // 36.56.0.0-36.63.255.255
                array('1038614528', '1039007743'), // 61.232.0.0-61.237.255.255
                array('1783627776', '1784676351'), // 106.80.0.0-106.95.255.255
                array('2035023872', '2035154943'), // 121.76.0.0-121.77.255.255
                array('2078801920', '2079064063'), // 123.232.0.0-123.235.255.255
                array('-1950089216', '-1948778497'), // 139.196.0.0-139.215.255.255
                array('-1425539072', '-1425014785'), // 171.8.0.0-171.15.255.255
                array('-1236271104', '-1235419137'), // 182.80.0.0-182.92.255.255
                array('-770113536', '-768606209'), // 210.25.0.0-210.47.255.255
                array('-569376768', '-564133889'), // 222.16.0.0-222.95.255.255
            );
            $rand_key = mt_rand(0, 9);
            $ip = long2ip(mt_rand($ip_long[$rand_key][0], $ip_long[$rand_key][1]));
        }
        session('userip',$ip);
    }
    return $ip;
}
function NOT_404(){
	@header("http/1.1 404 not found");
	@header("status: 404 not found");
	exit();
}
function encode($data){
	return base64_encode(http_build_query($data));
}

//加密
function ssl_encode($data){
	return base64_encode(openssl_encrypt(json_encode($data),'DES-EDE3', get_key()));
}
//解密
function ssl_decode($data){
	return json_decode(openssl_decrypt(base64_decode($data), 'DES-EDE3', get_key()),true);
}
function get_key(){
	return 'ss';
}
// 判断是否为手机端
function is_mobile() {
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
    {
        return true;
    }
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA']))
    {
        if(stripos($_SERVER['HTTP_VIA'], "wap") !== false){ //cdn情况下如果有wap就是手机否则继续往下判断
            return true;
        }
    }
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT']))
    {
        $clientkeywords = array ('nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap',
            'mobile',
            'nubia'
        );
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
        {
            return true;
        }
    }
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT']))
    {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
        {
            return true;
        }
    }
    return false;
}
