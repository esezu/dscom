<?php
/*
 * @Author: will
 * @Date: 2020-09-30 00:59:45
 * @LastEditTime: 2021-01-14 10:58:37
 * @LastEditors: will
 * @Description: 
 */
@error_reporting(E_ALL ^ E_NOTICE);
define("PAY_VERSION", '3'); //版本
//支付平台选择
define('PAY_WAY', 'sopay'); //sopay[sou支付]，juxin[聚新支付],yijia[壹加支付],ezhifu[易支付]，juyun[聚云]
define("PAY_APPID", "11442"); //你的appid
define("PAY_KEY", "54b55cb042e872655667476362a01053"); //你的秘钥
define('PAY_TYPE', 'alipay'); //支付类型微信wechat还是支付宝alipay





/*以下信息为可选项目*/
define("PAY_CHAT_MP", "xxxxx"); //公众号秘钥
define('PAY_URL', ''); //支付网关
define('PAY_POST', 'POST'); //POST或者GET
define('PAY_POST_ACTION', 'json'); //JSON或者form提交





require $_SERVER['DOCUMENT_ROOT'] . '/PaySdk/PayList.php';

/*
*****************************************
上面的信息可以自行配置,下面的不懂请勿修改!!!!!!!
以下参数无需修改,以下信息不懂请勿修改
*****************************************
*/

//获取下单地址
function PayCreateSdk($paydata)
{
    if (!is_array($paydata)) {
        exit("data错误");
    }

    $option_data = get_option($paydata);
    $data = $option_data['data'];
    $url = $option_data['url'];
    $data = array_merge($paydata, $data);
    if (empty($data['app_id'])) {
        exit("appkey没有填写");
    }
    if (empty($data['total_fee'])) {
        exit("金额不能为空");
    }
    if (empty($data['out_trade_no'])) {
        $data['out_trade_no'] = md5(time() . mt_rand(1, 1000000));
    }

    if (!empty($data['return_url'])) {
        $data['return_url'] = urlencode($data['return_url']); //
    }
    if (!empty($data['notify_url'])) {
        $data['notify_url'] = urlencode($data['notify_url']); //
    }
    $url_quer = http_build_query($data);
    $url .= $url_quer; //微信支付通道

    return $url;
}
