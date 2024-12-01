<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:88:"/usr/local/lighthouse/softwares/btpanel/wwwroot/dscom/apps/admins/view/user/adduser.html";i:1618529009;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/public/extend/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/public/static/css/public.css" media="all">
    
     <style>
        html, body {width: 98%;height: 98%;}
         body {background-color: #FFF;}
    </style>
</head>
<body style="width: 100%;height: 98%">
<div class="layuimini-main" style="margin-left: 5px;margin-top: 5px;">
<div class="layui-container">
<blockquote class="layui-elem-quote"><?php  if($id!= ''){echo '编辑('.$uinfo['username'].')';}else{echo '添加新账号';}  ?></blockquote>


<form class="layui-form" action="" style="margin-top: 20px">

    <?php   if($id == ''){  ?>
    <div class="layui-form-item">
        <label class="layui-form-label">账号</label>
        <div class="layui-input-block">
            <input type="text" name="username" value="<?php echo $uinfo['username']; ?>"  autocomplete="off" placeholder="请输入账号" class="layui-input">
        </div>
    </div>

    <?php  }  ?>
    <div class="layui-form-item">
        <label class="layui-form-label">密码</label>
        <div class="layui-input-block">
            <input type="text" name="password" value=""  autocomplete="off" placeholder="请输入密码" class="layui-input">
        </div>
    </div>
     <div class="layui-form-item">
        <label class="layui-form-label">代理等级</label>
        <div class="layui-input-block">
            <select name="is_all" lay-filter="is_all">
                <option value="1" <?php if($uinfo['is_all'] == 1){echo 'selected=""';} ?> >普通</option>
                <option value="2" <?php if($uinfo['is_all'] == 2){echo 'selected=""';} ?>>总代</option>
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">佣金比(%)</label>
        <div class="layui-input-block">
            <input type="number" name="fee" value="<?php echo $uinfo['fee']; ?>"  autocomplete="off" placeholder="费率" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">平台费率(%)</label>
        <div class="layui-input-block">
            <input type="number" name="ptfee" value="<?php echo $uinfo['ptfee']; ?>"  autocomplete="off" placeholder="费率" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">入口域名</label>
        <div class="layui-input-block">
            <input type="text" name="ename" value="<?php echo $uinfo['ename']; ?>"  autocomplete="off" placeholder="入口域名" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">快站域名</label>
        <div class="layui-input-block">
            <input type="text" name="kz" value="<?php echo $uinfo['kz']; ?>"  autocomplete="off" placeholder="快站域名" class="layui-input">
        </div>
    </div>
    <input type="hidden" name="id" value="<?php echo $id; ?>"> 
    <div class="layui-form-item">
        <center><button type="button" class="layui-btn layui-btn-normal" lay-submit lay-filter='save'>保存</button></center>
    </div>

</form>


</div>
    
 

</div>
<script src="/public/static/js/jquery.js" charset="utf-8"></script>
<script src="/public/extend/layui/layui.js" charset="utf-8"></script>
<script type="text/javascript">

layui.use(['form', 'table','layer'], function(){
    var form = layui.form;
    var table = layui.table;
    var layer = layui.layer;

    form.on('submit(save)', function(data){
        $.ajax({
            url:"<?php echo url(request()->action()); ?>",
            data:data.field,
            type:'post',
            dataType:'json',
            async: false,
            success:function(e) {
                layer.msg(e.msg);
                if(e.code == 200){
                   setTimeout(function(){
                     parent.window.location.reload();
                   },1000);
                   return false;
                }
            }
        });
        return false;
    });

})
</script>
</body>
</html>
