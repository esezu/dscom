<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:85:"/usr/local/lighthouse/softwares/btpanel/wwwroot/dscom/apps/admins/view/cus/order.html";i:1597109364;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>扣量订单</title>
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
              <button class="layui-btn layui-btn-normal" id="searchs">搜索</button>
            </div>
          </div>
          <table class="layui-table" lay-data="{height: 'full-115',  page: true, limit:12,id:'ajaxData', url:'<?php echo url('cus/order'); ?>'}" lay-filter="ajaxData">
            <thead>
              <tr>
                <th lay-data="{field:'ordersn'}">订单号</th>
                <th lay-data="{field:'tos'}">上游订单号</th>
                <th lay-data="{field:'title'}">标题</th>
                <th lay-data="{field:'payamount'}">金额</th>
                <th lay-data="{field:'buyid'}">用户</th>
                 <th lay-data="{field:'status'}">支付状态</th>
                <th lay-data="{field:'paytime'}">支付时间</th>
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
    });
    laydate.render({
        elem: '#etime'
    });
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
}) 
</script>

</body>
</html>
