<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:89:"/usr/local/lighthouse/softwares/btpanel/wwwroot/dscom/apps/admins/view/systems/index.html";i:1618549246;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>平台配置</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/public/extend/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/public/static/css/public.css" media="all">
    
     <style>
        html, body {width: 98%;height: 98%;}
         body {background-color: #FFF;}
         .layui-form-label{
            width:90px;
            padding-right: 0px;
            padding-left: 0px;
         }
         th{
          background-color: #eee
         }
    </style>
</head>
<body style="width: 100%;height: 98%">
<div class="layuimini-main" style="margin-left: 5px;margin-top: 5px;">
<div class="layui-container">
<blockquote class="layui-elem-quote">平台配置</blockquote>

<form class="layui-form" action="" style="margin-top: 20px">
<fieldset class="layui-elem-field site-demo-button" style="margin-top: 30px;">
  <legend>平台设置</legend>
    <div style="margin:10px">
      <table class="layui-table" style="width: 100%">
       <colgroup>
        <col width="20%">
        <col width="30%">
        <col width="20%">
        <col width="30%">
      </colgroup>
      <tbody>
      <tr>
        <th >打赏平台</th>
        <td><input type="checkbox" <?php  if($config['is_open'] == 2){  ?>  checked="" <?php  }  ?> name="is_open" lay-skin="switch"  lay-filter="pay"  lay-text="开启|关闭"> </td>
        <th>关闭网站跳转地址</th>
        <td class="ss" data-t='关闭网站跳转地址' data-name = 'ename'><?php echo $config['ename']; ?></td>
      </tr>
      <tr>
        <th>打赏金额强制整数</th> 
        <td><input type="checkbox" <?php  if($config['is_int'] == 2){  ?>  checked="" <?php  }  ?> name="is_int" lay-skin="switch"  lay-filter="pay"  lay-text="开启|关闭"></td>
        <th>快站域名</th> 
        <td class="ss" data-t='快站入口域名' data-name = 'kz_url'><?php echo $config['kz_url']; ?></td>
      </tr>
      <tr>
        <th>平台名称</th>
        <td class="ss" data-t='平台名称' data-name = 'title'><?php echo $config['title']; ?></td>
        <th>短网址名称</th>
        <td>1-urlc 2-麒麟默认 3-ft12 4-搜狗 5-新浪tcn</td>
      </tr>
      <tr>
        <th>域名价格</th> 
        <td class="ss" data-t='入口域名价格' data-name = 'enameamount'><?php echo $config['enameamount']; ?></td>
        <th>短连接生成规则</th> 
        <td class="ss" data-t='1-微信 2-ig' data-name = 'url'><?php echo $config['url']; ?></td>
      </tr>
      </tbody>
    </table>
    </div>
</fieldset>

<fieldset class="layui-elem-field site-demo-button" style="margin-top: 30px;">
  <legend>代理配置</legend>
    <div style="margin:10px">
      <table class="layui-table" style="width: 100%">
       <colgroup>
        <col width="20%">
        <col width="30%">
        <col width="20%">
        <col width="30%">
      </colgroup>
      <tbody>
        <tr>
          <th>注册功能</th> 
          <td> <input type="checkbox" <?php  if($config['is_reg'] == 2){  ?>  checked="" <?php  }  ?> name="is_reg" lay-skin="switch"  lay-filter="pay"  lay-text="开启|关闭"> </td>
          <th>注册自动设置扣量</th> 
          <td><input type="checkbox" <?php  if($config['kou'] == 2){  ?>  checked="" <?php  }  ?> name="kou" lay-skin="switch"  lay-filter="pay"  lay-text="开启|关闭"></td>

        </tr> 
        <tr> 
          <th>扣量开关</th> 
          <td> <input type="checkbox" <?php  if($config['is_kou'] == 2){  ?>  checked="" <?php  }  ?> name="is_kou" lay-skin="switch"  lay-filter="pay"  lay-text="开启|关闭"> </td>
          <th>默认扣量值</th>
          <td class="ss" data-t='默认扣量值' data-name = 'kounum'><?php echo $config['kounum']; ?></td>
        </tr>
        <tr>
          <th>注册邀请码</th> 
          <td><input type="checkbox" <?php  if($config['is_code'] == 2){  ?>  checked="" <?php  }  ?> name="is_code" lay-skin="switch"  lay-filter="pay"  lay-text="开启|关闭"></td>
          <th>邀请码价格</th>
          <td class="ss" data-t='邀请码价格' data-name = 'code_price'><?php echo $config['code_price']/100; ?></td>
        </tr>
        <tr>  
          <th>分佣费率(%)</th>
          <td class="ss" data-t='分佣费率' data-name = 'fee'><?php echo $config['fee']; ?></td>
          <th>平台费率(%)</th>
          <td class="ss" data-t='平台费率' data-name = 'pfee'><?php echo $config['pfee']; ?></td>
        </tr>
      </tbody>
    </table>
  </div>
</fieldset>


<fieldset class="layui-elem-field site-demo-button" style="margin-top: 30px;">
  <legend>提现配置</legend>
    <div style="margin:10px">
      <table class="layui-table" style="width: 100%">
       <colgroup>
        <col width="20%">
        <col width="30%">
        <col width="20%">
        <col width="30%">
      </colgroup>
      <tbody>
      <tr>  
          <th>最小提现金额</th>
          <td class="ss" data-t='最小提现金额' data-name = 'getminimoney'><?php echo $config['getminimoney']; ?></td>
          <th>最大提现金额</th>
          <td class="ss" data-t='最大提现金额' data-name = 'getmaxmoney'><?php echo $config['getmaxmoney']; ?></td>
        </tr>
      </tbody>
    </table>
  </div>
</fieldset>


</form>


</div>
    
 

</div>
<script src="/public/static/js/jquery.js" charset="utf-8"></script>
<script src="/public/extend/layui/layui.js" charset="utf-8"></script>
<script type="text/javascript">
layui.use(['form','layer'], function(){
  var form = layui.form;
  var layer = layui.layer;
  form.on('switch(pay)', function(data){ 
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
})
$(document).on('click','.ss',function(){

  var that = $(this);
  var n = that.attr('data-name');
  var t = that.attr('data-t');

layer.prompt({title: '修改'+t, formType: 0,value:that.html()}, function(pass, index){
    $.ajax({
      url:'<?php echo url("upde"); ?>',
      data:{n:n,v:pass},
      type:'post',
      dataType:'json',
      success:function(e){
        layer.msg(e.msg)
        if(e.code == 200){
          that.html(e.data);
          setTimeout(function(){
            layer.closeAll();
          return false;
      },800)
          return false;
        }
      }
    })
});

  
})
 
</script>
</body>
</html>
