<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:52:"/www/wwwroot/esezu/apps/admins/view/user/gminfo.html";i:1597109366;}*/ ?>
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
        .layui-table img{
          width: 300px;
          max-width:300px;
        }
      .layui-table th{
        text-align: center;
      }
      .layui-table td{
        text-align: center;
      }
    </style>
</head>
<body style="height: 58%">
  <div class="layuimini-main" style="margin-left: 5px;margin-top: 5px;">
    <div class="layui-container">
      <blockquote class="layui-elem-quote" style="font-size: 1.3rem"><?php echo $uinfo['username']; ?>(<?php echo $info['uid']; ?>)---提现</blockquote>
      <form class="layui-form" action="" style="margin-top: 20px">
          <table class="layui-table" style="width: 100%">
            <tbody>
              <tr>  
                <td width="80px">提现金额</td>
               <td style="font-size: 2rem;"><?php echo $info['money']; ?></td> 
             </tr>
             <tr>   
                <td width="80px">二维码</td>
               <td><img  height="300px" src="<?php echo $info['img']; ?>"></td> 
             </tr>
              
            </tbody>
          </table>
           <center>
             <div style="width: 200px">
      <button type="button" class="layui-btn layui-btn-fluid" id = 'doit'>确定打款</button>
    </div>
           </center>
        </form>
    </div>
  </div>
<script src="/public/static/js/jquery.js" charset="utf-8"></script>
<script src="/public/extend/layui/layui.all.js" charset="utf-8"></script>
<script type="text/javascript"> 

  $(function(){
    $('#doit').click(function(){
       $.ajax({
          url: '<?php echo url("ispass"); ?>',
          data:{id:<?php echo $info['id']; ?>,st:1},
          dataTyep:'json',
          type:'post',
           success:function(e){
            layer.msg(e.msg);
            if(e.code == 200){
              setTimeout(function(){
                parent.location.reload(); 
              },800)
              return false;
            }
          }
        })
    })
  })
</script>
</body>
</html>
