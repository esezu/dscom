<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:48:"/www/wwwroot/dscom/apps/cn/view/user/sviews.html";i:1619169486;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>模板</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/public/extend/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/public/static/css/public.css" media="all">
    
     <style>
        html, body {width: 98%;height: 98%;}
         body {background-color: #FFF;}
         .cssss{
            border: 3px solid #eee;
            padding: 2px;
            margin:10px;
            width: 250px;
         }
         .cssss img{
            margin:auto 0px;
            width: 100%;
         }
         .ccenter{
            background-color: #1E9FFF;
            color: #FFf;

         }
         .colors{
            border: 3px solid #1E9FFF;
         }
    </style>
</head>
<body style="width: 100%;height: 98%">
<div class="layuimini-main" style="margin-left: 5px;margin-top: 5px;">
<div class="layui-container">
<blockquote class="layui-elem-quote">模板尽量不要修改，使用🍓㈠号-新双列带搜索功能，或者四号模板</blockquote>
<form class="layui-form" action="" style="margin-top: 20px">
    <div class="layui-col-sm4 layui-col-md3 layui-col-lg2 cssss <?php  if($vid == 3){ echo 'colors';} ?>"    >
    <div class="layui-card">
    <img src="/public/upload/1.png" >
    <div class="ccenter">
    <center>
        <input type="radio" name="vid"  <?php  if($vid == 3){ echo 'checked="checked"';} ?>  value="3" title="新双列" >
    </center>
    </div>
    </div>
    </div>
    <div class="layui-col-sm4 layui-col-md3 layui-col-lg2 cssss <?php  if($vid == 4){ echo 'colors';} ?>">
    <div class="layui-card">
    <img src="/public/upload/2.png" >
    <div class="ccenter">
    <center>
        <input type="radio" name="vid" <?php  if($vid == 4){ echo 'checked="checked"';} ?>  value="4" title="新单列" >
    </center>
    </div>
    </div>
    </div>
    <div class="layui-col-sm4 layui-col-md3 layui-col-lg2 cssss <?php  if($vid == 5){ echo 'colors';} ?>">
    <div class="layui-card">
    <img src="/public/upload/5.png" >
    <div class="ccenter">
    <center>
        <input type="radio" name="vid" <?php  if($vid == 5){ echo 'checked="checked"';} ?>  value="5" title="无包月" >
    </center>
    </div>
    </div>
    </div>
    
    
    
    <!--hucxixi-->
    <div class="layui-col-sm4 layui-col-md3 layui-col-lg2 cssss <?php  if($vid == 6){ echo 'colors';} ?>">
    <div class="layui-card">
    <img src="/public/upload/6.png" >
    <div class="ccenter">
    <center>
        <input type="radio" name="vid" <?php  if($vid == 6){ echo 'checked="checked"';} ?>  value="6" title="新模板" >
    </center>
    </div>
    </div>
    </div>
    
    <div class="layui-col-sm4 layui-col-md3 layui-col-lg2 cssss <?php  if($vid == 7){ echo 'colors';} ?>">
    <div class="layui-card">
    <img src="/public/upload/7.png" >
    <div class="ccenter">
    <center>
        <input type="radio" name="vid" <?php  if($vid == 7){ echo 'checked="checked"';} ?>  value="7" title="单片-弹窗" >
    </center>
    </div>
    </div>
    </div>
    
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
            }
        });
        return false;
    });
     $('.cssss').click(function(){
        var s  = $(this).find('input').prop("checked", true);

        $('.cssss').removeClass('colors');
        $(this).addClass('colors');
        form.render();
    })
})
</script>
</body>
</html>