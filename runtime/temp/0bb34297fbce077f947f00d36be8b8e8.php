<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:51:"/www/wwwroot/esezu/apps/admins/view/user/index.html";i:1618528549;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>账号设置</title>
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




  <div class="layui-row">
    <div class="layui-col-xs12">
       <div class="layui-form" id="table-list">

          <div style="background-color: #eee;padding: 15px;">
            <div class="layui-input-inline">
              <input type="text" id="keys" value="" placeholder="用户名|id" autocomplete="off" class="layui-input">
            </div> 
             
            <div class="layui-inline">
              <button class="layui-btn layui-btn-normal" id="searchs">搜索</button>
            </div>
            <div class="layui-inline">
              <button class="layui-btn layui-btn-normal" id="getmoney">添加账号</button>
            </div>
          </div>
          <table class="layui-table" lay-data="{height: 'full-115',  page: true, limit:17,id:'ajaxData', url:'<?php echo url('user/index'); ?>'}" lay-filter="ajaxData">
            <thead>
              <tr>
                <th lay-data="{field:'id',width:80}">编号</th>
                <th lay-data="{field:'username',width:150}">账号</th>
                <th lay-data="{field:'ename',width:300}">入口域名</th>
                <th lay-data="{field:'money',width:150}">今日收入</th>
                <th lay-data="{field:'yesmoney',width:150}">昨日收入</th>
                <th lay-data="{field:'umoney',width:150}">账户余额</th>
                <th lay-data="{field:'ptfee',width:80}">费率</th>
                <th lay-data="{field:'fee',width:80}">分佣</th>
                <th lay-data="{field:'is_all',width:80}">级别</th>
                <th lay-data="{field:'fid',width:100}">上级</th>
                <th lay-data="{field:'status',width:100}">状态</th>
                <th lay-data="{field:'fuck'}">操作</th>
              </tr>
            </thead>
          </table>
        </div>
    </div> 
  </div>
</div>
<script src="/public/static/js/jquery.js" charset="utf-8"></script>
<script src="/public/extend/layui/layui.js" charset="utf-8"></script>
<script type="text/javascript">

layui.use(['laydate','table','layer','form'],function(){
    var laydate = layui.laydate;
    var table = layui.table;
    var layer = layui.layer;
    var form  = layui.form ;
    laydate.render({
        elem: '#stime'
    });
    laydate.render({
        elem: '#etime'
    });
    form.on('switch(pay)', function(data){ 
        console.log(data.elem);
        var a = data.elem.checked;
        var n = data.elem.name;
        $.ajax({
          url:'<?php echo url("updes"); ?>',
          data:{a:a,n:n},
          type:'post',
          dataType:'json',
          success:function(e){
            layer.msg(e.msg)
          }
        })
        return false;
        form.render();
    })  
    $('#searchs').on('click', function(){
        table.reload('ajaxData', {
            where: {
                keys: $('#keys').val(),
                stime:$('#stime').val(),
                etime:$('#etime').val(),
            },
            page: {
                page: 1 //重新从第 1 页开始
            }
        });
    });
    $('#getmoney').click(function(){
      layer.open({
          type: 2,
          title:'添加新账号',
          skin: 'layui-layer-demo', //样式类名
          area: ['800px', '90%'], //宽高
          shadeClose: true, //开启遮罩关闭
          content: "<?php echo url('adduser'); ?>"
        });
    })

}) 
function edit(id){
   layer.open({
          type: 2,
          title:'设置',
          skin: 'layui-layer-demo', //样式类名
          area: ['820px', '95%'], //宽高
          shadeClose: true, //开启遮罩关闭
          content: "<?php echo url('adduser'); ?>?id="+id
        });
}

function info(id){
   var index = layer.open({
          type: 2,
          title:'财务详情',
          skin: 'layui-layer-demo', //样式类名
          area: ['70%', '80%'], //宽高
          shadeClose: true, //开启遮罩关闭
          content: "<?php echo url('userinfo'); ?>?id="+id
        });
}

function deleteuser(id){
    $.ajax({
        url:'<?php echo url("deleteuser"); ?>',
        data:{id:id},
        type:'post',
        dataType:'json',
        success:function(e){
            layer.msg(e.msg);
            if(e.code == 200){
                setTimeout(function(){
                    window.location.reload();
                },1000);
                return false;
            }
        }
    })
}

</script>

</body>
</html>
