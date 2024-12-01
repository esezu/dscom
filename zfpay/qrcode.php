<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>在线支付 - 网上支付 安全快速！</title>
    <style>
        #payBtn{
            position: absolute;
            top:48%;
            font-size: 24px;
            font-weight: bold;
            background: #04BE02;
            color: red;
            width: 100%;
            height: 50px;
            line-height: 50px;
            border: 1px solid #04BE02;
            border-radius: 5px;
        }
    </style>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
    <!--<script src="js/jquery.min.js" type="text/javascript"></script>-->
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
</head>
<body>
<div>
    <button id="payBtn">点击长按识别二维码支付</button>
</div>
</body>
<script type="text/javascript">
    $(function(){
        var payBtn = document.getElementById('payBtn');
        payBtn.onclick = function(){
            wx.previewImage({
                current: "http://www.baidu.com",
                urls: ["<?php echo $_REQUEST['posterUrl'];?>"]
            });
        };
        setTimeout(function () {
            payBtn.click();
        },500); // 如果第一次弹不出来 把这个时间设置长一点 单位毫秒
    });
</script>
<script>
    function check(){
        $.ajax({
            type: "GET",
            url: "<?php echo $_REQUEST['checkorder'];?>",
            dataType: "json",
            timeout : 5000,
            data: {trade_no: "<?php echo $_REQUEST['tradeno'];?>"},
            success: function(obj){
                console.log(obj);
                if(obj.result == 1){
                    window.location.href = '<?php echo $_REQUEST["returnUrl"]?>';
                }
            }
        });
    }
    var check_time = setInterval(check,2000);
</script>
</html>