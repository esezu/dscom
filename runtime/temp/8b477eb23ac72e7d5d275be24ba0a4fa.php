<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:56:"/www/wwwroot/dscom/apps/admins/view/systems/mpwxadd.html";i:1605467492;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>添加公众号</title>
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
<blockquote class="layui-elem-quote">添加公众号</blockquote>

<form class="layui-form layui-form-pane container-fluid">
<fieldset class="layui-elem-field site-demo-button" style="margin: 20px 30px 20px 30px;">
      <div class="layui-tab-item layui-show" style="margin: 20px">
        <div class="layui-form-item">
          <label class="layui-form-label">公众号名称</label>
          <div class="layui-input-block">
            <input type="text" name="title"   required lay-verify="required"   placeholder="请输入公众号名称" autocomplete="off" class="layui-input">
          </div>
        </div>
          <div class="layui-form-item">
              <label class="layui-form-label">公众号appid</label>
              <div class="layui-input-block">
                  <input type="text" name="appid"   required lay-verify="required"   placeholder="请输入公众号appid" autocomplete="off" class="layui-input">
              </div>
          </div>
          <div class="layui-form-item">
              <label class="layui-form-label">公众号appsecret</label>
              <div class="layui-input-block">
                  <input type="text" name="appsecret"   required lay-verify="required"   placeholder="请输入公众号appsecret" autocomplete="off" class="layui-input">
              </div>
          </div>
      </div>
</fieldset> 


    <div class="layui-form-item">
        <center><button type="button" class="layui-btn layui-btn-normal" lay-submit lay-filter='save'>保存</button></center>
    </div>


</form>
</div>
    
 

</div>
<script src="/public/static/js/jquery.js" charset="utf-8"></script>
<script src="/public/extend/layui/layui.js" charset="utf-8"></script>
<script type="text/javascript">

layui.use(['form', 'table','layer','layedit'], function(){
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
