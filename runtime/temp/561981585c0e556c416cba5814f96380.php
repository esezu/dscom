<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:81:"/usr/local/lighthouse/softwares/btpanel/wwwroot/dscom/apps/p/view/home/list6.html";i:1618436341;}*/ ?>
<html lang="zh-cn" data-dpr="1" style="font-size: 41.4px;">
<head>
  <meta charset="UTF-8" />
  <title>支付后如未跳转请到已购观影</title>
  <meta name="viewport" content="width=device-width, initial-scale=1,minimum-scale=1, maximum-scale=1, user-scalable=no" />
  <link rel="stylesheet" type="text/css" href="https://www.layuicdn.com/layui/css/layui.css" />
  <link rel="icon" href="data:;base64,=" />
  <link rel="stylesheet" href="/public/css/list6.css?v=56693">
  <script src="/public/v1/js/jquery.js"></script>
  <script src="/public/v1/js/ajax.js"></script>
  <script src="/ckplayer/ckplayer.js"></script>
</head>
<body style="font-size: 12px;">
    
<?php if($boxvideo != ''){   ?>
<link rel="stylesheet" href="/public/v1/css/play.css">
<link rel="stylesheet" href="https://g.alicdn.com/de/prismplayer/2.8.7/skins/default/aliplayer-min.css" />
<div class="prism-player videobox" id="video"></div>
<script type="text/javascript" src="https://g.alicdn.com/de/prismplayer/2.8.7/aliplayer-min.js"></script>
<script src="/public/extend/layui/layui.js" charset="utf-8"></script>
<style type="text/css" media="all">
  .prism-player .prism-big-play-btn{
    left: 50% !important;
    bottom: 50% !important;
    margin-left: -32px;
    margin-bottom: -32px;
  }
  .prism-player .prism-controlbar{
    display: none;
  }
</style>
<script type="text/javascript">
 var videoObject = {
        container: '#video',
        variable: 'player', 
        
        autoplay: true, 
        poster: '', 
        video:'<?php echo $boxvideo; ?>',
        
        };
        var player = new ckplayer(videoObject);

</script>
<script type="text/javascript">
    $(function(){

        function duplay(url){
            // $('#player').attr('src',url);//
           
                }, function (player) {
                    
                }
            )
        }

        duplay("<?php echo $boxvideo; ?>");
        $(document).on('WeixinJSBridgeReady', () => {
            if (player.tag) {
            player.tag.play();
        }
    });
    })
</script>
<?php } ?>
<div class="video" style="height: auto;">
  <div class="nav navfixed"></div>
  <!--<div class="nav nav-search-bd">
    <div class="nav-search-input">
      <input type="text" name="search-title" class="search-title" id="search" placeholder="点击输入片名" />
    </div>
    <div class="nav-search-btn" id = 'dosearch'>
      点我搜索
    </div>
  </div>-->
</div>
<input type="hidden" name="page" id ='page' value = '1'>
<input type="hidden" name="cost" id ='cost' value = '<?php echo $c; ?>'>
<div class="box box_top">
  <ul class="list" id="list"></ul>
</div>
<div id="ts">
  <a href="/p/home/tousu">投诉</a>
</div>
<div id="footer">
    <a id="buyy" data-category_id="100"> 已购视频</a>
  <a id="huanyipi" data-category_id="false">热门视频</a>
  
  <a href="javascript:scroll(0,0)"> 返回顶部</a>
</div>
<!--弹出层-->
<div id="popbox" style="display: none;"></div>
<script src="https://cdn.bootcdn.net/ajax/libs/layui/2.5.7/layui.all.js"></script>
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
                        html += "<a style='color:yellow;font-size: 15.5px' onclick='javascript:layer.load(3,{shade:0.6});window.location.href=\"/l/<?php echo $id; ?>/c/"+item.id+"\"'>"+ item.cost +"</a> ";
                    }else {
                        html += "<a onclick='javascript:layer.load(3,{shade:0.6});window.location.href=\"/l/<?php echo $id; ?>/c/"+item.id+"\"'>"+ item.cost +"</a> ";
                    }
                })
                $('.navfixed').html(html)
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
    $(window).bind("scroll", function () {
        if ($(document).scrollTop() + $(window).height()
            > $(document).height() - 10 && !isloading) {
            isloading = true;
            getMore(1);
        }
    });
    getMore(1);
    function getMore(ss) {
        let html = ''
        var page = $('#page').val();
        var c =  $('#cost').val();
        var u = '/p/home/gl?id=<?php echo $id; ?>&c='+c+'&page='+page;
        $.ajax({
            url:u,
            dataType:'json',
            type:'post',
            success:function(e){
                var html = '';
                $.each(e,function(index,item){
                    const isPay = item.urlp === 1 || item.bao
                    if(isPay){
                    html  += '<li onclick="javascript:window.location.href=\''+item.link+'\'">';
                    }else {
                    html  += '<li class="video_items" price="'+item.price+'"dl = "'+item.urld+'"  pl ="'+item.urlp+'"  imgurl="'+item.cover+'">';
                    }
                    html  += '<a class="payMsg" href="javascript:void(0)">';
                    html  += '<div class="list_img">';
                    html  += '<img src="'+item.cover+'" /></div>';
                    html  += '<div class="list_info">';
                    if(isPay) {
                      html  += '<h3>立即观看</h3>';
                    }else {
                      html  += '<h3>'+item.paynum+'人付款，价格￥'+item.price+'元</h3>';
                    }
                    html  += '<div>'+ item.title +'</div>';
                    html  += '</div>';
                    html  += '</a>';
                    html  += '</li>';
                })
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
        var price = $(this).attr('price')
        var imgurl = $(this).attr('imgurl')
        var  pl = $(this).attr('pl')
        var  dl = $(this).attr('dl')
        var shtml = '';
        shtml  += '<div id="msg">';
        shtml  += '<img id="msgImg" style="width:100%;max-height:200px;margin-bottom:16px;" src="'+imgurl+'" />';
        shtml  += '<a id="pay_url" onclick="javascript:layer.load(3,{shade:0.6,content :\'正在支付\'});window.location.href =\''+pl+'\';">打赏<span id="priceMsg">'+price+'</span>元观看</a>';
        <?php if($uinfo['dayopen'] == 1): ?>
        shtml  += '<a id="pay_url_bt" href="/pay/<?php echo ssl_encode(['i'=>$uinfo['vid'],'u'=>$uinfo['id'],'p'=>$uinfo['dayamount'],'t'=>2]); ?>">全站包天&yen;<?php echo number_format($uinfo['dayamount']/100); ?>元</a>';
        <?php endif; if($uinfo['weekopen'] == 1): ?>
        shtml  += '<a id="pay_url_bt" href="/pay/<?php echo ssl_encode(['i'=>$uinfo['vid'],'u'=>$uinfo['id'],'p'=>$uinfo['weekamount'],'t'=>3]); ?>">全站包周&yen;<?php echo number_format($uinfo['weekamount']/100); ?>元</a>';
        <?php endif; if($uinfo['moonopen'] == 1): ?>
        shtml  += '<a id="pay_url_bt" href="/pay/<?php echo ssl_encode(['i'=>$uinfo['vid'],'u'=>$uinfo['id'],'p'=>$uinfo['moonamount'],'t'=>4]); ?>">全站包月&yen;<?php echo number_format($uinfo['moonamount']/100); ?>元</a>';
        <?php endif; ?>
        shtml  += '<a id="btn2">我在想想</a>';
        shtml  += '<br />';
        shtml  += '</div>';
        $('#popbox').html(shtml);
        $('#popbox').show();
    })
    $("body").on('click','#btn2',function(){
        $("#popbox").hide();
    });
</script>
<!--<?php if($uinfo['tc']==1): ?>
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
</body>
</html>