<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:54:"/www/wwwroot/dscom/apps/admins/view/user/getmoney.html";i:1597109366;}*/ ?>
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




  <div class="layui-row">
    <div class="layui-col-xs12">
       <div class="layui-form" id="table-list">

          <div style="background-color: #eee;padding-left:15px;">
            <div class="layui-input-inline">
              <input type="text" id="keys" value="" placeholder="订单号|代理id|代理账号" autocomplete="off" class="layui-input">
            </div> 
            
            <div class="layui-inline">
              <button class="layui-btn layui-btn-normal" id="searchs">搜索</button>
            </div>
            <div class="layui-input-inline" style="margin-left: 200px">
                <table class="layui-table" >
                  <tr>
                    <th>未打款金额：</th>
                    <td width="200px"><?php echo $notpay; ?></td>
                    <th>已打款金额：</th>
                    <td width="200px" ><?php echo $dopay; ?></td>
                  </tr>
                </table>
            </div> 
          </div>
          <table class="layui-table" lay-data="{totalRow:true,height: 'full-115',  page: true, limit:16,id:'ajaxData', url:'<?php echo url('user/getmoney'); ?>'}" lay-filter="ajaxData">
            <thead>
              <tr>
                <th lay-data="{field:'ordersn' , totalRowText: '合计行'}">订单号</th>
                <th lay-data="{field:'img',event: 'showimg'  ,totalRowText: '已经打款'}">收款码</th>
                <th lay-data="{field:'money'}">金额</th>
                <th lay-data="{field:'username',totalRowText: '未打款'}">用户(id)</th>
                <th lay-data="{field:'ctime'}">发起时间</th> 
                <th lay-data="{field:'statuss'}">状态</th>
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
    laydate.render({
        elem: '#stime'
    });
    laydate.render({
        elem: '#etime'
    });
    table.on('tool(ajaxData)', function(obj){
      var data = obj.data;
       if(obj.event =='showimg'){
          layer.open({
        type: 1,
        title: false,
        closeBtn: 0,
         area: ['500px', 'auto'],
        skin: 'layui-layer-nobg', //没有背景色

        shadeClose: true,
        content: data.img
      });
       }
    })
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
function pass(id){ 
      layer.open({
          type: 2,
          title:'打款',
          skin: 'layui-layer-demo', //样式类名
          area: ['650px', '650px'], //宽高
          shadeClose: true, //开启遮罩关闭
          content: "<?php echo url('gminfo'); ?>?id="+id
        });
}
function nopass(id){
 ajax(id,2);
}
function ajax(id,st){
  $.ajax({
    url: '<?php echo url("ispass"); ?>',
    data:{id:id,st:st},
    dataTyep:'json',
    type:'post',
     success:function(e){
      layer.msg(e.msg);
      if(e.code == 200){
        setTimeout(function(){
          window.location.reload(); 
        },800)
        return false;
      }
    }
  })
}



</script>

</body>
</html>
