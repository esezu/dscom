<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:53:"/www/wwwroot/esezu/apps/admins/view/video/classl.html";i:1613566428;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>分类列表</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/public/extend/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/public/static/css/public.css" media="all">
    
     <style>
        html, body {width: 98%;height: 98%;}
        body {background-color: #FFF;overflow:-Scroll;overflow-y:hidden;}
    </style>
</head>
<body style="width: 100%;height: 98%">
<div class="layuimini-main" style="margin-left: 5px;margin-top: 5px;">




  <div class="layui-row">
    <div class="layui-col-xs12">
       <div class="layui-form" id="table-list">
    <div style="background-color: #eee;padding: 15px;">
            
            
             
            <div class="layui-inline">
             <button type="button"  class="layui-btn layui-btn-normal " onclick="getadd()">分类添加</button>
            </div>

           

          </div>
          
          <table class="layui-table" lay-data="{height: 'full-100',limit:30,id:'ajaxData', url:'<?php echo url('video/classl'); ?>'}" lay-filter="ajaxData">
            <thead>
              <tr>
                <th lay-data="{field:'id',width:100}">编号</th>
                <th lay-data="{field:'title',width:650}">标题</th>
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
layui.use(['laydate','table','layer'],function(){
    var laydate = layui.laydate;
    var table = layui.table;
    var layer = layui.layer;
    $('#searchs').on('click', function(){
        table.reload('ajaxData', {
            where: {
                keys: $("#keys").val(),
                title:$('#title').val()
            },
            page: {
                page: 1 //重新从第 1 页开始
            }
        });
    });
    table.on('tool(ajaxData)', function(obj){
      var data = obj.data;
       if(obj.event =='showimg'){
       layer.open({
          type: 1,
          title:false,
          skin: 'layui-layer-demo', //样式类名
          closeBtn: 0, //不显示关闭按钮
          anim: 2,
          shadeClose: true, //开启遮罩关闭
          content: data.cover
        });
       }
    })
   
    window.getlink = function(id){


      layer.prompt({title: '请输入要修改的分类名称', formType: 2,area: ['200px', '20px'] ,maxlength:9999999999}, function(text, index){

         $.ajax({
          url:'<?php echo url("editclass"); ?>',
          type:'post',
          data:{name:text,id:id},
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


        });
    }
    
   window.getadd = function(){


      layer.prompt({title: '请输入分类名称', formType: 2,area: ['200px', '20px'] ,maxlength:9999999999}, function(text, index){

         $.ajax({
          url:'<?php echo url("addclass"); ?>',
          type:'post',
          data:{name:text},
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


        });
    }
    
    
    window.delclass = function(id){
       $.ajax({
        url:'<?php echo url("video/delclass"); ?>?id='+id,
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
}) 
</script>

</body>
</html>
