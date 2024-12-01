<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:81:"/usr/local/lighthouse/softwares/btpanel/wwwroot/dscom/apps/p/view/home/list7.html";i:1618437539;}*/ ?>

<!-- saved from url=(0070)http://tttjk.n1f52yg.cn/l/MUsrWlVRbEtheFcrZFJrZVVTclFMTDFmUXdwTXVGMjk= -->
<html lang="zh-cn" data-dpr="1">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <link id="layuicss-laydate" rel="stylesheet" href="/public/v1/css/laydate.css" media="all">
  <link id="layuicss-layer" rel="stylesheet" href="/public/v1/css/layer.css" media="all">
  <link id="layuicss-skincodecss" rel="stylesheet" href="/public/v1/css/code.css" media="all">
  <title>支付后未跳转请到已购观影</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" type="text/css" href="/public/v1/css/layui.css">
  <link rel="stylesheet" href="/public/v1/css/list7.css">
  <script src="/public/v1/css/jquery.js"></script>
  </head>
  <body style="font-size: 12px;">
  <script src="/public/v1/css/ajax.js"></script>
  <script>
      function onBridgeReady() {
          WeixinJSBridge.call('hideOptionMenu');
          WeixinJSBridge.call('hideToolbar');
      }
      if (typeof WeixinJSBridge == "undefined") {
          if (document.addEventListener) {
              document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
          } else if (document.attachEvent) {
              document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
              document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
          }
      } else {
          onBridgeReady();
      }
  </script>

<div class="wrap root">
   
    
  <div class="index">
    <div class="view" id="index_view">
      <div class="v-body">
        <div class="video-type">
          <div class="type-row"> </div>
          
        </div>
        <input type="hidden" name="page" id="page" value="1">
        <input type="hidden" name="cost" id="cost" value="all">
        <div class="list" id="list"></div>
      </div>
      <br>
    </div>
    <div class="foot" style="margin-left:-5px">
      <div class="type-item foot-item" id="huanyipi">
        •热门推荐
      </div>
      <div>
        <div class="foot-item foot-active" id="buyy">
          ✚已购买
        </div>
      </div>
      <div class="foot-item" onclick="totop()">
        返回顶部
      </div>
    </div>
  </div>
</div>
<!--弹出层-->
<div id="popbox" style="display: none;"></div>
<script src="/public/v1/css/layui.all.js"></script>
<script>
    var layer = layui.layer;
    //获取链接
    $(function(){
        var index = layer.load(3);
        $.ajax({
            url:'/p/home/cost',
            success:function(e){
                layer.close(index);
                var html = '';
                $.each(e.msg,function(index,item){
                    if(item.id == "<?php echo $c; ?>"){
                        html += "<a class='type-item yigou' style='font-size:16px;' onclick='javascript:layer.load(3,{shade:0.6});window.location.href=\"/l/<?php echo $id; ?>=/c/"+item.id+"\"'>"+ item.cost +"</a> ";
                    }else {
                        html += "<a class='type-item' style='font-size:16px;' onclick='javascript:layer.load(3,{shade:0.6});window.location.href=\"/l/<?php echo $id; ?>/c/"+item.id+"\"'>"+ item.cost +"</a> ";
                    }
                })
                $('.video-type .type-row').html(html)
            }
        })
    })
    $('#dosearch').click(function(){
        layer.load(3,{shade:0.6});
        var s = $('#search').val();
        window.location.href = "/l/<?php echo $id; ?>?k="+s
    })
    $('#buyy').click(function(){
        layer.load(3,{shade:0.6});
        window.location.href = '/l/<?php echo $id; ?>/c/buy';
        return false;
    })
    $("#huanyipi").click(function(){
        window.location.reload();
    });
    var s = $('#search').val();
    $('.view').bind("scroll", function () {
        if ($(document).scrollTop() + $(window).height()
            > $(document).height() - 10 && !isloading) {
            isloading = true;
            getMore(1);
        }
    });
    function totop() {
        $('.view')[0].scroll(0,0);
    }
    getMore(1);
        function getMore(ss) {
        let html = ''
        var page = $('#page').val();
        var c =  $('#cost').val();
        var u = '/p/home/gl?id=<?php echo $id; ?>&c=<?php echo $c; ?>&page='+page;
        $.ajax({
            url:u,
            dataType:'json',
            type:'post',
            success:function(e){
                var html = '';
                $.each(e,function(index,item){
                     if(item.urlp == 1 || item.day==1){
                            console.log(item.link);
                            html  += ' <div class="list-item mt20 video_items" onclick="javascript:window.location.href=\''+item.link+'\'" >';
                        }else{
                             html  += '<div class="list-item mt20 video_items" title="'+item.title+'" price="'+item.price+'"dl = "'+item.urld+'"  pl ="'+item.urlp+'"  imgurl="'+item.cover+'">';
                        }
                    
                   
                    html  += '<div class="img-wrap">';
                    html  += '<img alt="" class="thumb" src="'+item.cover+'" />';
                    html  += '<span class="img-tips-left">已有'+item.paynum+'人付款<font style="color:#FF0000;font-size:0.23rem;font-weight:bold">'+item.price+'</font>元观看</span>';
                    html  += '</div>';
                    html  += '<div class="video-title">'+ item.title +'</div>';
                    html  += '</div>';
                        
                });
                $('#page').val(parseInt($('#page').val()) + 1);
                isloading = false;
                if(ss == 1){
                    $('#list').append(html)
                }else{
                    $('#list').html(html)
                }
            }
        })
    }
        $('body').on('click', '.video_items', function(e) {
        var price = $(this).attr('price');
        var imgurl = $(this).attr('imgurl');
        var title = $(this).attr('title');
        var  pl = $(this).attr('pl');
        var  dl = $(this).attr('dl');
        var shtml = '';
        shtml += '<div class="mod">';
        shtml += '<div class="mod-img-wrap">';
        shtml += '<img alt="" class="mod-img" src="'+imgurl+'" />';
        shtml += '</div>';
        shtml += '<div class="mod-title">'+title+'</div>';
        shtml += '<div class="mod-foot">';
        shtml += '<div class="mod-foot-item mod-active" onclick="javascript:window.location.href =\''+pl+'\';">';
        shtml += '打 赏 '+price+' 元 观 看';
        shtml += '</div>';
        <?php if($uinfo['dayopen']==1): ?> 
         shtml += '<div class="mod-foot-item mod-active" onclick="javascript:window.location.href =\''+dl+'\';">';
         shtml += '包天 <?php echo number_format($uinfo['dayamount']/100); ?> 元看全部视频 ';
         shtml += '</div>';
        <?php endif; ?>
        shtml += '<div id="btn2" class="mod-foot-item flex-1">取 消</div>';
        shtml += '</div>';
        shtml += '</div>';
        $('#popbox').html(shtml);
        $('#popbox').show();
    });
    $("body").on('click','#btn2',function(){
        $("#popbox").hide();
    });
</script>
<!--
<?php if($uinfo['tc']==1): ?>
<script>

function tc(){
        
      layer.open({
          type: 1,
          title:'温馨提示',
          skin: 'layui-layer-demo', //样式类名
          closeBtn: 1, //不显示关闭按钮
          area: ['315px', '390px'],
          anim: 2,
          shadeClose: true, //开启遮罩关闭
          content:'<div style="color:red;text-align:center;font-size:14px">长按二维码或截图保存收藏防止走失</div>'+
          '<img src="https://api.pwmqr.com/qrcode/create/?url=<?php echo $uinfo["tcurl"] ?>">'
        }); 
    }

  setTimeout("tc()",1000);   
    


</script>
<?php endif; ?>-->
<div class="layui-layer-move"></div></body></html>