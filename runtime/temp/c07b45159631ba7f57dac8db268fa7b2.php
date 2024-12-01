<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:86:"/usr/local/lighthouse/softwares/btpanel/wwwroot/dscom/apps/admins/view/home/login.html";i:1618279644;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?>-登陆</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="/public/extend/layui/css/layui.css" media="all">
 
    <style>
        html, body {width: 100%;height: 100%;overflow: hidden}
        body {background: #1E9FFF;}
        body:after {content:'';background-repeat:no-repeat;background-size:cover;-webkit-filter:blur(3px);-moz-filter:blur(3px);-o-filter:blur(3px);-ms-filter:blur(3px);filter:blur(3px);position:absolute;top:0;left:0;right:0;bottom:0;z-index:-1;}
        .layui-container {width: 100%;height: 100%;overflow: hidden}
        .admin-login-background {width:360px;height:300px;position:absolute;left:50%;top:40%;margin-left:-180px;margin-top:-100px;}
        .logo-title {text-align:center;letter-spacing:2px;padding:14px 0;}
        .logo-title h1 {color:#1E9FFF;font-size:25px;font-weight:bold;}
        .login-form {background-color:#fff;border:1px solid #fff;border-radius:3px;padding:14px 20px;box-shadow:0 0 8px #eeeeee;}
        .login-form .layui-form-item {position:relative;}
        .login-form .layui-form-item label {position:absolute;left:1px;top:1px;width:38px;line-height:36px;text-align:center;color:#d2d2d2;}
        .login-form .layui-form-item input {padding-left:36px;}
        .captcha {width:60%;display:inline-block;}
        .captcha-img {display:inline-block;width:34%;float:right;}
        .captcha-img img {height:34px;border:1px solid #e6e6e6;height:36px;width:100%;}
    </style>
</head>
<body>
<div class="layui-container">
    <div class="admin-login-background">
        <div class="layui-form login-form">
            <form class="layui-form" action="" id = 'databox'  method="post">
                <div class="layui-form-item logo-title">
                    <h1><?php echo $title; ?></h1>
                </div>
                <div class="layui-form-item">
                    <label class="layui-icon layui-icon-username" for="username"></label>
                    <input type="text" name="account" lay-verify="required|account" placeholder="用户名或者邮箱" autocomplete="off" class="layui-input" value="">
                </div>
                <div class="layui-form-item">
                    <label class="layui-icon layui-icon-password" for="password"></label>
                    <input type="password" name="password" lay-verify="required|password" placeholder="密码" autocomplete="off" class="layui-input" value="">
                </div>
                <div class="layui-form-item">
                    <label class="layui-icon layui-icon-vercode" for="captcha"></label>
                    <input type="text" name="verify" lay-verify="required|verify" placeholder="图形验证码" autocomplete="off" class="layui-input verification captcha" value="">
                    <div class="captcha-img">
                        <img  id="captcha" src="<?php echo captcha_src(); ?>" onclick="this.src='<?php echo captcha_src(); ?>?seed='+Math.random()" />
                    </div>
                </div>
               
                <div class="layui-form-item">
                    <a href="javascript:;" class="layui-btn layui-btn layui-btn-normal layui-btn-fluid" lay-submit="" lay-filter="login">登 入</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="/public/static/js/jquery.js" charset="utf-8"></script>
<script src="/public/extend/layui/layui.js" charset="utf-8"></script>
<script src="/public/static/jq-module/jquery.particleground.min.js" charset="utf-8"></script>
<script>
    layui.use(['form'], function () {
        var form = layui.form,
            layer = layui.layer;

        // 登录过期的时候，跳出ifram框架
        if (top.location != self.location) top.location = self.location;

        // 粒子线条背景
       //  $(document).ready(function(){
       //      $('.layui-container').particleground({
        //         dotColor:'#7ec7fd',
        //         lineColor:'#7ec7fd'
        //     });
        // });
        $(document).keydown(function () {
        　　if (event.keyCode == 13) {
           　　dologin();
      　　  }
    　　 });
        // 进行登录操作
        // 进行登录操作
        form.on('submit(login)', function () {
            dologin();
           
        });
        window.dologin = function(){
             


        var account = $('input[name=account]').val(); 
        var password = $('input[name=password]').val(); 
        var verify = $('input[name=verify]').val(); 

            if (account == '') {
                layer.msg('用户名不能为空');
                return false;
            }
            if (password == '') {
                layer.msg('密码不能为空');
                return false;
            }
            if (captcha == '') {
                layer.msg('验证码不能为空');
                return false;
            }
            $.ajax({
                    url:"<?php echo url('home/login'); ?>",
                    data:{account:account,password:password,verify:verify},
                    type:'post',
                    dataType:'json',
                    async: false,
                    success:function(res) {
                        layer.msg(res.msg);
                        if(res.code == 200) {
                            setTimeout(function() {
                                window.location.href = '<?php echo url("index"); ?>';
                            }, 1000);
                            return false;
                        } else {
                            $('#verify').val('');
                            $('#captcha').click();
                        }
                    }
                });
            return false;
        }
        return false;
    });
</script>
</body>
</html>