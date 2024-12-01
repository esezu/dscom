<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:51:"/www/wwwroot/dscom/apps/admins/view/news/index.html";i:1597109364;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>消息</title>
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
              <input type="text" id="keys" value="" placeholder="公告标题" autocomplete="off" class="layui-input">
            </div> 
            
            <div class="layui-inline">
              <button class="layui-btn layui-btn-normal" id="searchs">搜索</button>
              <div class="layui-inline tool-btn">
              <button class="layui-btn layui-btn-small layui-btn-normal addBtn" onclick="showDiyWin();return false;">添加公告</button>
            </div>
            </div>
          </div>
          <table class="layui-table" lay-data="{height: 'full-115',  page: true, limit:12,id:'ajaxData', url:'<?php echo url('news/index'); ?>'}" lay-filter="ajaxData">
            <thead>
              <tr>
                <th lay-data="{field:'id'}">编号</th>
                <th lay-data="{field:'title'}">标题</th>
                <th lay-data="{field:'ctime'}">创建时间</th>  
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
})  
 function delnews(id){
    layer.confirm('确定要删除吗？', {
    btn: ['确定']
    }, 
    function(){
      $.ajax({
        url:'<?php echo url("deletenews"); ?>',
        data:{id,id},
        type:'post',
        dataType:'json',
        success:function(e){
          layer.msg(e.msg);
          if(e.code==200){
            setTimeout(function(){
              window.location.reload();
            },800);
          }
        }
      })
    });
  }
  function showDiyWin(){
     layer.open({
          type: 2,
          title:'添加公告',
          skin: 'layui-layer-demo', //样式类名
          area: ['820px', '95%'], //宽高
          shadeClose: true, //开启遮罩关闭
          content: "<?php echo url('info'); ?>"
        });
  }
</script>

</body>
</html>