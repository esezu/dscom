<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:50:"/www/wwwroot/dscom/apps/admins/view/video/che.html";i:1597109368;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>视频设置</title>
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
<blockquote class="layui-elem-quote">批量替换</blockquote>


<form class="layui-form" action="" style="margin-top: 20px">
 
    <div class="layui-form-item">
        <label class="layui-form-label">播放地址(旧)</label>
        <div class="layui-input-block">
            <input type="text" name="ourl" value=""  placeholder="旧播放地址" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">播放地址(新)</label>
        <div class="layui-input-block">
            <input type="text" name="nurl" value=""  placeholder="新播放地址" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">封面地址(旧)</label>
        <div class="layui-input-block">
            <input type="text" name="ocove" value=""  placeholder="旧封面地址" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">封面地址(新)</label>
        <div class="layui-input-block">
            <input type="text" name="ncove" value=""  placeholder="新封面地址" class="layui-input">
        </div>
    </div>

 

    <div class="layui-form-item">
        <center><button type="button" class="layui-btn layui-btn-normal" lay-submit lay-filter='save'>全部替换</button></center>
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
                     parent.location.reload();
                 },800);
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
