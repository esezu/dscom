<?php
/*
 * @Author: will
 * @Date: 2020-09-30 00:15:18
 * @LastEditTime: 2021-01-16 22:22:34
 * @LastEditors: will
 * @Description: 
 */

error_reporting(0);
header("Content-type: text/html; charset=utf-8");

/*开启后直接从数据调用id跟秘钥,否则从/PaySdk/Config.php文件调用*/
//define("PAY_APPID", "138"); //你的appid
//define("PAY_KEY", "22"); //你的秘钥
//define('PAY_TYPE', 'wechat'); //支付类型微信还是支付宝wechat或者alipay

if (!function_exists('PayCreateSdk')) {
  require $_SERVER['DOCUMENT_ROOT'] . '/PaySdk/Config.php';
}

$payData = array(
  'uid' => "2222", //你的网站用户id
  'out_trade_no' => time(), //订单号
  'total_fee' => 2, //金额
  'param' => "333", //其他参数,可返回回调里面
  'return_url' => 'http://' . $_SERVER['HTTP_HOST'], //异步回调地址
  'notify_url' => "http://www.baidu.com", //支付成功后返回
);
$geturl = PayCreateSdk($payData);
exit("<meta http-equiv='Refresh' content='0;URL={$geturl}'>");
