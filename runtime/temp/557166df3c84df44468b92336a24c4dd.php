<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:46:"/www/wwwroot/dscom/apps/cn/view/user/edit.html";i:1612549588;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>个人设置</title>
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
<blockquote class="layui-elem-quote">个人中心</blockquote>


<form class="layui-form" action="" style="margin-top: 20px">
    <div class="layui-form-item">
        <label class="layui-form-label">密码</label>
        <div class="layui-input-block">
            <input type="password" name="password" value=""  autocomplete="off" placeholder="不填则不修改密码" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">最小金额</label>
        <div class="layui-input-block">
            <input type="number" name="mini" value="<?php echo $uinfo['mini']; ?>"  autocomplete="off" placeholder="最小金额" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">最大金额</label>
        <div class="layui-input-block">
            <input type="number" name="max" value="<?php echo $uinfo['max']; ?>" lay-verify="title" autocomplete="off" placeholder="最大金额" class="layui-input">
        </div>
    </div>
    
    <div class="layui-form-item">
        <label class="layui-form-label">打赏模式</label>
        <div class="layui-input-block">
            <select name="is_fixed" lay-filter="is_fixed">
                <option value="1" <?php if($uinfo['is_fixed'] == 1){echo 'selected=""';} ?>  >随机</option>
                <option value="2" <?php if($uinfo['is_fixed'] == 2){echo 'selected=""';} ?>>固定取最大值</option>
            </select>
        </div>
    </div>

    <div class="layui-form-item">
    <label class="layui-form-label">包天</label>
        <div class="layui-input-inline" style="width: 10%;">
            <input type="checkbox"  <?php  if($uinfo['dayopen'] == 1){echo 'checked=""';}  ?> name="dayopen" lay-skin="switch" lay-text="关闭|开启">
        </div>
         <div class="layui-input-inline" style="width: 50%;">
        <input type="number" name="dayamount"  value = "<?php echo $uinfo['dayamount']/100; ?>" autocomplete="off" placeholder="请输入包天价格" class="layui-input">
      </div>
    </div>
     <div class="layui-form-item">
    <label class="layui-form-label">包周</label>
        <div class="layui-input-inline" style="width: 10%;">
            <input type="checkbox" <?php  if($uinfo['weekopen'] == 1){echo 'checked=""';}  ?>  name="weekopen" lay-skin="switch"  lay-text="关闭|开启">
        </div>
         <div class="layui-input-inline" style="width: 50%;">
        <input type="number" name="weekamount"  value = "<?php echo $uinfo['weekamount']/100; ?>" autocomplete="off" placeholder="请输入包周价格" class="layui-input">
      </div>
    </div>
     <div class="layui-form-item">
    <label class="layui-form-label">包月</label>
        <div class="layui-input-inline" style="width: 10%;">
            <input type="checkbox" <?php  if($uinfo['moonopen'] == 1){echo 'checked=""';}  ?>  name="moonopen" lay-skin="switch"  lay-text="关闭|开启">
        </div>
         <div class="layui-input-inline" style="width: 50%;">
        <input type="number" name="moonamount"  value = "<?php echo $uinfo['moonamount']/100; ?>" autocomplete="off" placeholder="请输入包月价格" class="layui-input">
      </div>
    </div>
    <div class="layui-form-item">
    <label class="layui-form-label">二维码弹窗</label>
        <div class="layui-input-inline" style="width: 10%;">
            <input type="checkbox" <?php  if($uinfo['tc'] == 1){echo 'checked=""';}  ?>  name="tc" lay-skin="switch"  lay-text="关闭|开启">
        </div>
         <div class="layui-input-inline" style="width: 50%;">
        <input type="text" name="tcurl"  value = "<?php echo $uinfo['tcurl']; ?>" autocomplete="off" placeholder="请弹窗链接" class="layui-input">
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
