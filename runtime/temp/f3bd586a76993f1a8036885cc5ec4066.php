<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:52:"/www/wwwroot/esezu/apps/admins/view/video/index.html";i:1618526289;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>片库列表</title>
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
            <div class="layui-input-inline">

              <select name="keys" id = 'keys' lay-verify="required" lay-search="">
                <option value="">请选择类型</option>
                <?php  foreach($cost as   $v){  ?>
                  <option value="<?php echo $v['id']; ?>"><?php echo $v['cost']; ?></option>
                <?php  }  ?>
              </select>

            </div> 
            <div class="layui-inline">
                <div class="layui-input-inline">
                  <input type="text" class="layui-input" id ='title' placeholder="请输入标题">
                </div>
              </div>
             
            <div class="layui-inline">
              <button class="layui-btn layui-btn-normal" id="searchs">搜索</button>
            </div>

            <div class="layui-inline"  style="float: right;">
              <button type="button"  class="layui-btn layui-btn-normal " onclick="getlink()">批量添加</button>
              <button type="button"  class="layui-btn layui-btn-normal " onclick="che()">批量替换</button>
              <button type="button"  class="layui-btn layui-btn-normal " onclick="ches()">替换入口</button>
              <button type="button"  class="layui-btn layui-btn-normal " onclick="sele()">检查视频</button>
              <button type="button"  class="layui-btn layui-btn-normal " onclick="delt()">删除视频</button>
            </div>

          </div>
          <table class="layui-table" lay-data="{height: 'full-100',  page: true, limit:17,id:'ajaxData', url:'<?php echo url('video/index'); ?>'}" lay-filter="ajaxData">
            <thead>
              <tr>
                <th lay-data="{field:'id',width:100}">编号</th>
                <th lay-data="{field:'title',width:650}">标题</th>
                <th lay-data="{field:'cover',width:150,event: 'showimg'}">封面</th>
                <th lay-data="{field:'url'}">播放地址</th>
                <th lay-data="{field:'cost'}">类型</th>
                <th lay-data="{field:'ctime'}">修改时间</th>
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
    window.getlink = function(){


      layer.prompt({title: '格式为 视频|标题|图片|分类', formType: 2,area: ['1000px', '750px'] ,maxlength:9999999999}, function(text, index){

         $.ajax({
          url:'<?php echo url("addlist"); ?>',
          type:'post',
          data:{list:text},
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
     window.sele = function(){
     layer.open({
            type: 2,
            title:'资源检查',
            skin: 'layui-layer-demo', //样式类名
            area: ['70%', '70%'], //宽高
            shadeClose: true, //开启遮罩关闭
            content: "<?php echo url('video/sele'); ?>",
            end:function(){
               table.reload('ajaxData');
            }
          });
    }
      
    window.che = function(id){
     layer.open({
            type: 2,
            title:'链接替换',
            skin: 'layui-layer-demo', //样式类名
            area: ['820px', '600px'], //宽高
            shadeClose: true, //开启遮罩关闭
            content: "<?php echo url('video/che'); ?>",
            end:function(){
               table.reload('ajaxData');
            }
          });
    }
    window.ches = function(id){
     layer.open({
            type: 2,
            title:'链接替换',
            skin: 'layui-layer-demo', //样式类名
            area: ['820px', '600px'], //宽高
            shadeClose: true, //开启遮罩关闭
            content: "<?php echo url('video/ches'); ?>",
            end:function(){
               table.reload('ajaxData');
            }
          });
    }
    
    window.delt = function(){
      layer.prompt({title: '删除页数:1-10', formType: 0,value:'1-10'}, function(text, index){
         $.ajax({
          url:'<?php echo url("deleteall"); ?>',
          type:'post',
          data:{txt:text},
          dateType:'json',
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
    window.del = function(id){
       $.ajax({
        url:'<?php echo url("video/del"); ?>?id='+id,
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
