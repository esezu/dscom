<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:82:"/usr/local/lighthouse/softwares/btpanel/wwwroot/dscom/apps/p/view/pay/waiting.html";i:1599502916;}*/ ?>
<!DOCTYPE html>
<html>
<meta charset="utf-8">
<title>跳转中</title>
<meta name="description" content="">
<meta http-equiv="X-UA-Compatible" content="chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0"> 
<meta name="apple-mobile-web-app-status-bar-style" content="black"> 
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="format-detection" content="telephone=no">


	<title>跳转中</title>
</head>
<body>
<script src="/public/js/layermobile/layer.js" charset="utf-8"></script>
<script type="text/javascript">
 layer.open({
    type: 2,
    shadeClose:false
    ,content: '跳转中'
  });

</script>
<script src="/public/static/js/jquery.js" charset="utf-8">
</script>
<script type="text/javascript">
	$(function(){
		todo("<?php echo $id; ?>");
		function todo(id){
			$.ajax({
				url:'<?php echo url("pay/getorder"); ?>',
				data:{id:id},
				type:'post',
				success:function(e){
					if(e == 1){
						setTimeout(
							function(){
								todo(id)
							}
						,1000);
						return false;
					}
					if(e == 2){
						window.location.href = "/play/"+id;
					}
					return false;
					
				}
			})
		}
	})
</script>
</body>
</html>