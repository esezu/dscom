<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:88:"/usr/local/lighthouse/softwares/btpanel/wwwroot/dscom/apps/admins/view/systems/edit.html";i:1597109366;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>支付通道</title>
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
<blockquote class="layui-elem-quote">支付通道</blockquote>


<form class="layui-form" action="" style="margin-top: 20px">

    <div class="layui-form-item">
        <label class="layui-form-label">通道名称</label>
        <div class="layui-input-block">
            <input type="text" name="title" value="<?php echo $info['title']; ?>"  autocomplete="off" placeholder="通道名称" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">接口地址</label>
        <div class="layui-input-block">
            <input type="text" name="url" value="<?php echo $info['url']; ?>"  autocomplete="off" placeholder="接口地址" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">key</label>
        <div class="layui-input-block">
            <input type="text" name="key" value="<?php echo $info['key']; ?>"  autocomplete="off" placeholder="key" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">appid</label>
        <div class="layui-input-block">
            <input type="text" name="appid" value="<?php echo $info['appid']; ?>"  autocomplete="off" placeholder="appid" class="layui-input">
        </div>
    </div> 
    <input type="hidden" name="id" value="<?php echo $info['id']; ?>">

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
            async: false,success:function(e) {
                layer.msg(e.msg);
                if(e.code ==200){
                    setTimeout(function(){
                        parent.window.location.reload();
                    },1000)
                }
            }
        });
        return false;
    });
})
</script>
</body>
</html>