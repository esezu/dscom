<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:49:"/www/wwwroot/dscom/apps/p/view/pay/qiqizhifu.html";i:1645300545;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="Content-Language" content="zh-cn">
    <meta name="apple-mobile-web-app-capable" content="no"/>
    <meta name="apple-touch-fullscreen" content="yes"/>
    <meta name="format-detection" content="telephone=no,email=no"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="white">
    <meta name="renderer" content="webkit"/>
    <meta name="force-rendering" content="webkit"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1"/>
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-control" content="no-cache">
    <meta http-equiv="Cache" content="no-cache">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>扫码支付</title>
    <link href="/public/static/pay/static/css/pay.css" rel="stylesheet" media="screen">
    <link href="/public/static/pay/static/css/paybtn.css" rel="stylesheet" media="screen">
    <link href="/public/static/pay/static/css/toastr.min.css" rel="stylesheet" media="screen">
    <script src="/public/static/pay/static/js/jquery.min.js"></script>
</head>

<body>
<div class="body" id="body">

    <h1 class="mod-title">
        <span class="ico_log ico-1"></span>
    </h1>

    <div class="mod-ct">
        <div class="order">
        </div>
        <div class="amount" id="timeOut" style="font-size:18px;color: red;display: none;"><p>订单已过期，请您返回网站重新发起支付</p><br></div>
        <div id="orderbody">
            <!--<div class="amount" style="font-size:22px;color: #FF00FF;"><span>提示风险时点击【继续支付】即可</span></div>-->
            <div class="amount" style="font-size:22px;color: #FF00FF;"><span>请截图保存二维码到手机,打开微信使用扫一扫识别保存的二维码</span></div>
            <div class="amount" style="font-size:22px;color: #FF00FF;"><span>有问题加客服微信W963380</span></div>
            <div class="amount" id="money">￥<span id="copy_money" style="color:red;"><?php echo $paydata['totalAmount']; ?></span>元</div>
            <div class="qrcode-img-wrapper" data-role="qrPayImgWrapper">
                <div data-role="qrPayImg" class="qrcode-img-area">
                    <div class="ui-loading qrcode-loading" data-role="qrPayImgLoading" style="display: none;">加载中</div>
                    <div style="position: relative;display: inline-block;">
                        <img id='show_qrcode' alt="加载中..." src="https://api.pwmqr.com/qrcode/create/?url=<?php echo $paydata['payCode']; ?>" width="250" height="250" style="display: block;">
                    </div>
                </div>
            </div>

            <div class="time-item">
                <div class="time-item" id="msg" style="margin-bottom:6px;">
                    <h1><span style="color:red; font-size:1.7rem;">提示：金额必须输入正确，否则不跳转<br>网络延迟没有跳转，请返回已购里观看</span><br></h1>
                </div>
                <strong id="hour_show">0时</strong>
                <strong id="minute_show">0分</strong>
                <strong id="second_show">0秒</strong>
            </div>

            <div class="tip" style="margin-top:10px;">
                <div class="ico-scan"></div>
                <div class="tip-text" style="margin-left:10px;">
                    <p>请保存二维码到手机使用扫一扫</p>
                    <p>然后选择本地图片支付后查看已购</p>
                </div>
            </div>

            <div class="detail" id="orderDetail">
                <dl class="detail-ct" id="desc" style="display: none;">
                    <dt>订单金额：</dt>
                    <dd><?php echo $paydata['totalAmount']; ?></dd>
                    <dt>商户订单号：</dt>
                    <dd><?php echo $paydata['billNo']; ?></dd>
                    <dt>创建时间：</dt>
                    <dd><?php echo date('Y-m-d H:i:s',time()); ?></dd>
                    <dt>订单状态</dt>
                    <dd>等待支付</dd>
                </dl>

                <a href="javascript:void(0)" class="arrow" onclick="aaa()"><i class="ico-arrow"></i></a>
            </div>
        </div>

        <div class="tip-text"><a id="alink" href="<?php echo $paydata['returnUrl']; ?>" style="visibility: hidden;display:none;">下一步</a> </div>

    </div>
    <div class="foot">
        <div class="inner">
            <p>手机用户可保存上方二维码到手机中</p>
            <p>在微信扫一扫中选择“相册”即可</p>
        </div>
    </div>
</div>


<div class="copyRight"></div>

<script src="/public/static/pay/static/js/toastr.min.js"></script>

<script>
    function aaa() {
        if ($('#orderDetail').hasClass('detail-open')) {
            $('#orderDetail .detail-ct').slideUp(500, function () {
                $('#orderDetail').removeClass('detail-open');
            });
        } else {
            $('#orderDetail .detail-ct').slideDown(500, function () {
                $('#orderDetail').addClass('detail-open');
            });
        }
    }
    function formatDate(now) {
        now = new Date(now*1000)
        return now.getFullYear()
            + "-" + (now.getMonth()>8?(now.getMonth()+1):"0"+(now.getMonth()+1))
            + "-" + (now.getDate()>9?now.getDate():"0"+now.getDate())
            + " " + (now.getHours()>9?now.getHours():"0"+now.getHours())
            + ":" + (now.getMinutes()>9?now.getMinutes():"0"+now.getMinutes())
            + ":" + (now.getSeconds()>9?now.getSeconds():"0"+now.getSeconds());

    }
    var myTimer;
    function timer(intDiff) {
        var i = 0;
        i++;
        var day = 0,
            hour = 0,
            minute = 0,
            second = 0;//时间默认值
        if (intDiff > 0) {
            day = Math.floor(intDiff / (60 * 60 * 24));
            hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
            minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
            second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
        }
        if (minute <= 9) minute = '0' + minute;
        if (second <= 9) second = '0' + second;
        $('#hour_show').html('<s id="h"></s>' + hour + '时');
        $('#minute_show').html('<s></s>' + minute + '分');
        $('#second_show').html('<s></s>' + second + '秒');
        if (hour <= 0 && minute <= 0 && second <= 0) {
            qrcode_timeout();
            clearInterval(myTimer);

        }
        intDiff--;

        myTimer = window.setInterval(function () {
            i++;
            var day = 0,
                hour = 0,
                minute = 0,
                second = 0;//时间默认值
            if (intDiff > 0) {
                day = Math.floor(intDiff / (60 * 60 * 24));
                hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
                minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
                second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
            }
            if (minute <= 9) minute = '0' + minute;
            if (second <= 9) second = '0' + second;
            $('#hour_show').html('<s id="h"></s>' + hour + '时');
            $('#minute_show').html('<s></s>' + minute + '分');
            $('#second_show').html('<s></s>' + second + '秒');
            if (hour <= 0 && minute <= 0 && second <= 0) {
                qrcode_timeout()
                clearInterval(myTimer);

            }
            intDiff--;
        }, 1000);
    }

    function qrcode_timeout(){
        document.getElementById("orderbody").style.display = "none";
        document.getElementById("timeOut").style.display = "";
    }

    function getQueryString(name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
        var r = window.location.search.substr(1).match(reg);
        if (r != null)
            return decodeURI(r[2]);
        return null;
    }
    timer(300);
    check();
    function check() {
        $.ajax({
            type: "POST",
            url: '/p/pay/getorder',
            data:{'id':"<?php echo $paydata['billNo']; ?>"},
            success: function (data) {
                if (data == 2){
                    window.location.href = "<?php echo $paydata['returnUrl']; ?>";
                    return;
                } else{
                    setTimeout("check()",1000);
                }
            },
            error: function (err) {
                setTimeout("check()",1000);
            }
        })
    }

</script>
<script>
    //禁止滚动
    document.body.addEventListener('touchmove', function (e) {e.preventDefault();}, {passive: false});
</script>
</body>
</html>