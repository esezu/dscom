<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:56:"/www/wwwroot/esezu/apps/admins/view/systems/paylist.html";i:1597109366;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>系统设置</title>
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
    <div class="layui-row layui-col-space15" >
      <div class="layui-col-xs15 layui-col-md15">
        <table class="layui-table">
          <thead>
            <tr>
              <th>编号</th>
              <th>通过到名称</th>
              <th>接口地址</th>
              <th>key</th>
              <th>appid</th>
              <th>添加时间</th>
              <th>修改时间</th>
              <th>操作</th>
            </tr> 
          </thead>
          <tbody>
           <?php  foreach($list as $v){  ?>
                <tr>
                  <td><?php echo $v['id']; ?></td>
                  <td><?php echo $v['title']; ?></td>
                  <td><?php echo $v['url']; ?></td>
                  <td><?php echo $v['key']; ?></td>
                  <td><?php echo $v['appid']; ?></td>
                  <td><?php echo $v['ctime']; ?></td>
                  <td><?php echo $v['utime']; ?></td>
                  <td><?php echo $v['fuck']; ?></td>
                </tr>
            <?php  }  ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
<script src="/public/static/js/jquery.js" charset="utf-8"></script>
<script src="/public/extend/layui/layui.js" charset="utf-8"></script>
<script type="text/javascript">
layui.use(['form','layer'], function(){
  var form = layui.form;
  var layer = layui.layer;
 
})
function edit(id){
  layer.open({
        type: 2,
        title:'设置',
        skin: 'layui-layer-demo', //样式类名
        area: ['820px', '55%'], //宽高
        shadeClose: true, //开启遮罩关闭
        content: "<?php echo url('edit'); ?>?id="+id
      });

}
 
</script>

</body>
</html>
