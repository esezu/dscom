<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:56:"/www/wwwroot/esezu/apps/admins/view/systems/payedit.html";i:1599213868;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>支付设置</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/public/extend/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/public/static/css/public.css" media="all">
    
     <style>
        html, body {width: 98%;height: 98%;}
         body {background-color: #FFF;}
         .layui-form-label{
            width:90px;
            padding-right: 0px;
            padding-left: 0px;
         }
    </style>
</head>
<body style="width: 100%;height: 98%">
<div class="layuimini-main" style="margin-left: 5px;margin-top: 5px;">
<div class="layui-container">
<blockquote class="layui-elem-quote">支付配置</blockquote>


<form class="layui-form" action="" style="margin-top: 20px">
    
    <div class="layui-form-item">
        <label class="layui-form-label">微信通道</label>
        <div class="layui-input-block">
            <select name="paytype" lay-filter="is_fixed">
                <?php  foreach($paylist as $k => $v){  ?>
                        <option value="<?php echo $v['id']; ?>" <?php if($info['paytype'] == $v['id']){echo 'selected=""';} ?>  ><?php echo $v['title']; ?></option>
                <?php  }  ?>
              
            </select>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">抖音通道</label>
        <div class="layui-input-block">
            <select name="no_wx" lay-filter="is_fixed">
                <?php  foreach($paylist as $k => $v){  ?>
                        <option value="<?php echo $v['id']; ?>" <?php if($info['no_wx'] == $v['id']){echo 'selected=""';} ?>  ><?php echo $v['title']; ?></option>
                <?php  }  ?>
              
            </select>
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
            beforeSend:function(){
                layer.msg('提交中...',{time:-1});
            },
            success:function(e) {
                layer.msg(e.msg);
            }
        });
        return false;
    });

})
</script>
</body>
</html>
