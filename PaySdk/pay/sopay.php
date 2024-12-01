<?php
@error_reporting(E_ALL ^ E_NOTICE);
header('Content-Type: text/html; charset=utf-8');



extract($_GET);
extract($_POST);

//获取来路
$notify_url = urldecode($notify_url); //来路
$return_url = urldecode($return_url); //解码支付成功后的页面

if (empty($return_url)) {
  $return_url = "/";
}
$payimg = "https://apiupload.oss-cn-beijing.aliyuncs.com/assets/zhifu.png";
if ($type == 'alipay') {
  $payimg = "https://apiupload.oss-cn-beijing.aliyuncs.com/assets/zhifubao.png";
}



?>
<!DOCTYPE html>
<html>

<head>
  <title><?php echo $pay_title ?></title>
  <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0" />
  <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <script src="https://apiupload.oss-cn-beijing.aliyuncs.com/assets/sopay.js?v=<?php echo  time() ?>"></script>

</head>

<body>
  <style>
    ol,
    ul {
      list-style: none;
    }

    img {
      max-width: 100%
    }

    body a {
      outline: none;
      blr: expression(this.onFocus=this.blur());
      text-decoration: none;
    }

    body {
      background-color: #F5F5F5;
      font-size: 16px;
      font-family: "微软雅黑";
    }

    * {
      padding: 0;
      margin: 0
    }

    /*充值*/
    .url_pay {
      background-color: #fff;
      max-width: 640px;
      margin: 0 auto;
      text-align: center;
    }

    .url_pay h2 {
      no-repeat;
      display: block;
      text-align: center;
      padding: 8px;
      border-bottom: 1px solid #ddd;
      margin-bottom: 5px;
    }

    .url_pay h2 img {
      max-height: 40px;
    }

    .url_pay h3 {
      font-size: 18px;
      color: #fb8000;
      padding: 5px 0
    }

    .url_pay h4 {
      font-size: 12px;
    }

    .url_pay h4 span {
      background-color: #4CAF50;
      color: #fff;
      padding: 2px;
      border-radius: 4px;
    }

    .url_pay h5 {
      font-size: 14px;
      color: #fb8000;
      padding: 5px;
      border: 3px dashed #000;
      text-align: left;
      margin: 5px;
    }


    .qr {
      width: 60%;
      margin: 0 auto;
    }

    .qr img {
      max-width: 100%
    }

    .total_fee {
      color: #f03a00;
      font-weight: bold;
      font-size: 26px;
      padding: 0 8px
    }

    #time {
      color: #e42f07;
      font-size: 24px;
    }

    .payok {
      display: block;
      width: 80%;
      border: 1px solid #148519;
      background-color: #4CAF50;
      color: #fff;
      text-align: center;
      padding: 4px;
      margin: 10px auto;
    }

    #base64img {
      max-width: 200px;
      margin: 10px auto;
    }

    #myProgress {
      width: 100%;
      background-color: #ddd;
    }

    #myBar {
      width: 100%;
      height: 30px;
      background-color: #4CAF50;
      text-align: center;
      line-height: 30px;
      background-image: linear-gradient(to right, #e9e610, #4CAF50);
      color: white;
    }
  </style>

  <div class="url_pay">
    <h2><img src="<?php echo $payimg ?>" /></h2>
    <div class="warp">
      <h3>请付款<span style="font-size:34px">👉</span><span class="total_fee"></span>元</h3>
      <h4>支付成功后请耐心等待3-6秒,自动跳转(<span>多付少付不到账</span>)</h4>
      <div class="qr"><img src="https://apiupload.oss-cn-beijing.aliyuncs.com/assets/lodding.png" id="base64img" /></div>
      <div id="myProgress">
        <div id="myBar">100%</div>
      </div>
      <h6>支付倒计时:<span class="exprie_time" id="time"></span>秒</h6>
      <a href="<?php echo $return_url ?>" class="payok">支付完成点击这里</a>

      <h5>1：付款时务必于金额一致,擅自修改金额会导致掉单,
        <br />2：本次支付订单号:<span class="order_no"></span>
        <br />3：金额已自动复制,请粘贴付款
        <br />4：不到账请联系客服
      </h5>
    </div>
  </div>



  <script>
    //解决防封框架内iframe内IOS不能扫码
    $('body').on('touchstart', 'img', function() {
      var src = $(this).attr('src')
      if (src.indexOf("http") == -1 && src.indexOf("data:") == -1) {
        src = document.location.protocol + "//" + document.location.host + "/" + src;
      }
      window.parent.postMessage(JSON.stringify({
        state: 1,
        url: src
      }), '*');
    }).on('touchend', function() {
      window.parent.postMessage(JSON.stringify({
        state: 2
      }), '*');
    })


    $(document).ready(function() {
      SoPay.post({
        app_id: "<?php echo $app_id ?>", //
        type: "<?php echo $type ?>", //
        uid: "<?php echo $uid ?>",
        total_fee: "<?php echo $total_fee ?>",
        out_trade_no: "<?php echo $out_trade_no ?>",
        timestamp: "<?php echo $timestamp ?>",
        return_url: "<?php echo $return_url ?>",
        notify_url: "<?php echo $notify_url ?>",
        param: "<?php echo $param ?>",
        sign: "<?php echo $sign ?>",
        callback: function(res) {
          //获取二维码后显示的函数
          console.log(res);
          if (res.code != 1) {
            swal('错误', res.msg, 'error')
            return
          }
          $("#base64img").attr("src", res.data.pay_url);
          $(".total_fee").html(res.data.really_total_fee);
          $(".exprie_time").html(res.data.exp_time);
          $(".order_no").html(res.data.out_trade_no);

          //提示复制金额
          copytotal_fee(res)
          //设置倒计时

          $('#time').countdown(res.data.exp_time, function(event) {
            var width = '';
            var s = event.offset.minutes * 60 + event.offset.seconds;
            var elem = document.getElementById("myBar");
            width = (s / res.data.exp_seconds_time * 100).toFixed(2);
            elem.style.width = width + '%';
            elem.innerHTML = width * 1 + '%';
            $(this).html(s);
          }).on('finish.countdown', function(event) {
            $("#base64img").attr("src", 'https://apiupload.oss-cn-beijing.aliyuncs.com/assets/shixiao.png');
          });
        },
        success: function(data) {
          //支付成功后的函数
          alert("支付成功");
          console.log(data);
          $("#base64img").attr("src", 'https://apiupload.oss-cn-beijing.aliyuncs.com/assets/payok.png');
          window.location.href = "<?php echo $return_url ?>"
        }
      });

    });
  </script>


</body>