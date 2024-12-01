<?php
/***
 * 此为获取到收款数据后查询的接口
 * 上传到你服务器即可 不需要动任何东西
 */
$post_data = $_POST;
$header = array('Ktype:iscurl', 'User-Agent:' . $_SERVER['HTTP_USER_AGENT']);
$a=http_post("http://chaxun.fangyoufang.net/index.php",$header,$post_data);
echo $a;


 function http_post($sUrl, $aHeader, $aData) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $sUrl);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($aData));
    $sResult = curl_exec($ch);
    if ($sError = curl_error($ch)) {
        die($sError);
    }
    curl_close($ch);
    return $sResult;
}