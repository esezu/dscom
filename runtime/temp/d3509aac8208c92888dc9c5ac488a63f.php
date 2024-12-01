<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:50:"/www/wwwroot/dscom/apps/p/view/home/videoinfo.html";i:1644506330;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>支付后未跳转请到已购观看</title>
  <link rel="stylesheet" href="/public/v1/css/pay.css">
  <script src="/public/v1/js/jquery.js"></script>
</head>
<body>
<script>
function onBridgeReady() {
    WeixinJSBridge.call('hideOptionMenu');
}
 
if (typeof WeixinJSBridge == "undefined") {
    if (document.addEventListener) {
        document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
    } else if (document.attachEvent) {
        document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
        document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
    }
} else {
    onBridgeReady();
}
// function isWeiXin() {
//     var ua = window.navigator.userAgent.toLowerCase();
//     console.log(ua);//mozilla/5.0 (iphone; cpu iphone os 9_1 like mac os x) applewebkit/601.1.46 (khtml, like gecko)version/9.0 mobile/13b143 safari/601.1
//     if (ua.match(/MicroMessenger/i) == 'micromessenger') {
//         return true;
//     } else {
//         return false;
//     }
// }
// if (!isWeiXin()) {
//   window.location.href ='http://www.baidu.com';
// }
</script>

  <div class="mark" style="background-image: url(<?php  echo '/public/img/'.rand(1,3).'.jpg';  ?>);"></div>
  <div class="content" id = 'content'></div>
  <!--<script src="https://cdn.bootcdn.net/ajax/libs/layui/2.5.7/layui.all.js"></script>-->
  <!--<script src="/public/layui/js/layui/layui.all.js"></script>-->
  <script src="/public/extend/layui/layui.all.js"></script>
  <script>
    $(document).ready(function() {
        var layer = layui.layer;
      function getRndInteger(min, max) {
        return (Math.random() * (max - min + 1) + min).toFixed(1);
      }
      var size = $('.size'), time = $('.time')
      size.text(getRndInteger(50, 120))
      time.text(getRndInteger(30, 60))
      $.ajax({
      	url:'/p/home/showvideo?id=<?php echo $id; ?>',
      	success:function(e){
      		$('#content').html(e);
      	}
      })
    })
  </script>
</body>
</html>