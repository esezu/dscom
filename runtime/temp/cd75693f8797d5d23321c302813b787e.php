<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:49:"/www/wwwroot/esezu/apps/admins/view/user/sys.html";i:1597109366;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>订单</title>
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
              <input type="text" id="keys" value="" placeholder="订单号" autocomplete="off" class="layui-input">
            </div> 
             <div class="layui-inline">
                <div class="layui-input-inline">
                  <input type="text" class="layui-input" id ='stime' placeholder="开始时间">
                </div>
              </div>

            <div class="layui-inline">
                <div class="layui-input-inline">
                  <input type="text" class="layui-input" id ='etime' placeholder="结束时间">
                </div>
              </div>

              <div class="layui-inline">
                <div class="layui-input-inline">
                  <input type="text" class="layui-input" id ='uid' placeholder="用户id">
                </div>
              </div>
            <div class="layui-inline">
              <button class="layui-btn layui-btn-normal" id="searchs">搜索</button>
            </div>
            <div class="layui-inline" style="float: right;">
              <button class="layui-btn layui-btn-normal" id="dday">删除订单</button>
            </div>
          </div>
          <table class="layui-table" lay-data="{height: 'full-115',  page: true, limit:17,id:'ajaxData', url:'<?php echo url('sys'); ?>'}" lay-filter="ajaxData">
            <thead>
              <tr>
                <th lay-data="{field:'ordersn'}">订单号</th>
                <th lay-data="{field:'amount'}">金额</th>
                <th lay-data="{field:'status'}">类型</th>
                <th lay-data="{field:'uname'}">用户(id)</th>
                <th lay-data="{field:'msg'}">备注</th>
                <th lay-data="{field:'ctime'}">支付时间</th>
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
    laydate.render({
        elem: '#stime'
        ,type: 'datetime'
    });
    laydate.render({
        elem: '#etime'
        ,type: 'datetime'
    });
    $('#searchs').on('click', function(){
        table.reload('ajaxData', {
            where: {
                keys: $('#keys').val(),
                stime:$('#stime').val(),
                etime:$('#etime').val(),
                uid:$('#uid').val(),  
            },
            page: {
                page: 1 //重新从第 1 页开始
            }
        });
    });
}) 
$('#dday').click(function(){
  layer.prompt({  formType: 0, title: '删除N天前的数据' }, function(value, index ){
      if(value <2 ){
        layer.msg('最低删除两天前的订单');
        return false;
      }
      $.ajax({
        url:"<?php echo url('dday'); ?>",
        data:{number:value},
        type:"post",
        success:function(e){
            layer.msg(e.msg);
           if(e.code == 200){
             setTimeout(function(){
              layer.closeAll();
            },800);

            }
            return false;
        }
      })

  });
})
</script>

</body>
</html>
