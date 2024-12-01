<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:87:"/usr/local/lighthouse/softwares/btpanel/wwwroot/dscom/apps/admins/view/ename/index.html";i:1618538114;}*/ ?>
              
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>入口域名列表</title>
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
              <input type="text" id="keys" value="" placeholder="域名" autocomplete="off" class="layui-input">
            </div> 
            
            <div class="layui-inline">
              <button class="layui-btn layui-btn-normal" id="searchs">搜索</button>
                
            </div>
            <div class="layui-inline" style="float: right;">
              
              <button class="layui-btn layui-btn-normal" onclick="adds()">批量添加</button>
            </div>
          </div>
          <table class="layui-table" lay-data="{height: 'full-130',  page: true, limit:16,id:'ajaxData', url:'<?php echo url('ename/index'); ?>'}" lay-filter="ajaxData">
            <thead>
              <tr>
                <th lay-data="{field:'id'}">编号</th>
                <th lay-data="{field:'ename'}">域名</th>
                <th lay-data="{field:'status'}">状态</th>
                <th lay-data="{field:'ctime'}">添加时间</th>
                <th lay-data="{field:'username'}">使用者</th>
                <th lay-data="{field:'utime'}">更新时间</th>
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

layui.use(['laydate','table'],function(){
    var laydate = layui.laydate;
    var table = layui.table;
   
    $('#searchs').on('click', function(){
        table.reload('ajaxData', {
            where: {
                keys: $('#keys').val(),
            },
            page: {
                page: 1 //重新从第 1 页开始
            }
        });
    });
    
window.st = function(id,st){
  $.ajax({
        url:'<?php echo url("ename/st"); ?>',
        data:{id:id,st:st},
        type:"post",
        dateType:'json',
        success:function(e){
          layer.msg(e.msg);
          if(e.code =200){
            setTimeout(function(){
              table.reload('ajaxData');
            },800)
            return false;
          }
        }
      })
}

 window.del = function(id){
       $.ajax({
        url:'<?php echo url("ename/del"); ?>?id='+id,
        dateType:'json',
        success:function(e){
          layer.msg(e.msg);
          if(e.code =200){
            setTimeout(function(){
              table.reload('ajaxData');
            },800)
            return false;
          }
        }
      })
    }


window.adds = function(){
  layer.prompt({title: '请输入域名', formType: 2,area: ['800px', '350px'] ,maxlength:9999999999}, function(text, index){
      $.ajax({
        url:'<?php echo url("ename/addsindex"); ?>',
        dateType:'json',
        type:'post',
        data:{ts:text},
        success:function(e){
          layer.msg(e.msg);
          if(e.code =200){
            setTimeout(function(){
             layer.closeAll();
              table.reload('ajaxData');
            },800)
            return false;
          }
        }
      })

  });
}

}) 
 

</script>

</body>
</html>