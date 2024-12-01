<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:83:"/usr/local/lighthouse/softwares/btpanel/wwwroot/dscom/apps/admins/view/cus/add.html";i:1602176260;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>添加扣量</title>
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
<blockquote class="layui-elem-quote">添加扣量</blockquote>


<form class="layui-form" action="" style="margin-top: 20px">


     <div class="layui-form-item">
        <label class="layui-form-label">用户</label>
        <div class="layui-input-block">
            <select name="uid" lay-filter="cost">
                <?php  foreach($ulist as $v){  ?>
                    <option value="<?php echo $v['id']; ?>"  ><?php echo $v['username']; ?></option>
                <?php  }  ?>
        </select>
        </div>
    </div>



    <div class="layui-form-item">
        <label class="layui-form-label">初始值</label>
        <div class="layui-input-block">
            <input type="number" name="num" value="" lay-verify="title" autocomplete="off" placeholder="初始值" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">扣量值</label>
        <div class="layui-input-block">
            <input type="number" name="surplus" value="" lay-verify="title" autocomplete="off" placeholder="扣量值" class="layui-input">
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