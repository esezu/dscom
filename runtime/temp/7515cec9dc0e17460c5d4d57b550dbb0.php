<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:50:"/www/wwwroot/esezu/apps/cn/view/order/domoney.html";i:1611598654;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>提现</title>
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
<blockquote class="layui-elem-quote">可提现金额：<?php echo $money; ?></blockquote>
<form class="layui-form" action="" style="margin-top: 20px">
    <div class="layui-form-item">
        <label class="layui-form-label">提现金额</label>
        <div class="layui-input-block">
            <input type="number" name="money" value=""  autocomplete="off" placeholder="提现金额" class="layui-input">
        </div>
    </div>
 <!--   <div class="layui-form-item">
                    <label class="layui-form-label">收款账号</label>
                    <div class="layui-input-block">
                        <input type="number" name="shoukuanzh"  placeholder="请输入收款账号" autocomplete="off" class="layui-input">
                    </div>
                </div>
				
				
				
				 <div class="layui-form-item">
                    <label class="layui-form-label">收款姓名</label>
                    <div class="layui-input-block">
                        <input type="number" name="shoukuanxm"  placeholder="请输入收款姓名" autocomplete="off" class="layui-input">
                    </div>
                </div>
				</div>-->
    <div class="layui-form-item">
        <label class="layui-form-label">收款码</label>
         <div class="layui-upload" style="">
            <div class="layui-upload-list" style="border: 1px solid #EEE;width: 200px;height: 200px;display: inline-block;"  >
            <img class="layui-upload-img" id="demo1" style="width: 100%;height: 100%" >
            <input type="hidden" name="img" id = 'img1'>
          </div>
         
          <div style="display: inline-block;width: 200px;"> <button type="button" class="layui-btn" id="test1" style="">上传收款码</button></div>
        </div> 

    </div>
   

    <div class="layui-form-item">
        <center><button type="button" class="layui-btn layui-btn-normal" lay-submit lay-filter='save'>提交</button></center>
    </div>
</form>
</div>
</div>
<script src="/public/static/js/jquery.js" charset="utf-8"></script>
<script src="/public/extend/layui/layui.js" charset="utf-8"></script>
<script type="text/javascript">

layui.use(['form', 'table','layer','upload'], function(){
    var form = layui.form;
    var table = layui.table;
    var layer = layui.layer;
    var upload = layui.upload;
    upload.render({
    elem: '#test1',
    url: '<?php echo url("upload"); ?>',
    before: function(obj){
      obj.preview(function(index, file, result){
        $('#demo1').attr('src', result);

      });
    },done: function(res){



      if(res.code > 0){
        return layer.msg('上传失败');
      }


      $('#img1').val(res.data.src);
    }
    
  });
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
