<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:81:"/usr/local/lighthouse/softwares/btpanel/wwwroot/dscom/apps/p/view/home/list5.html";i:1618545795;}*/ ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>🎈支付后如未跳转请到已购观影</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="screen-orientation" content="portrait">
  <meta name="x5-orientation" content="portrait">
  <link rel="stylesheet" type="text/css" href="/public/extend/layui/css/layui.css" />
  <link rel="stylesheet" href="/public/v2/css/iconfont.css">
  <link rel="stylesheet" href="/public/v2/css/gg.css">
  <link rel="stylesheet" href="/public/v2/css/index2.css">
  <style type="text/css" media="all">
    .layui-layer-loading .layui-layer-content{
      padding-top: 25px;
      color: #fff;
    }
  </style>
  <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
  <script>
      (function () {
          change();
          function change() {
              document.documentElement.style.fontSize = document.documentElement.clientWidth * 20 / 320 + 'px';
          }
          window.addEventListener('resize', change, false);
      })()
  </script>
  <script src="/public/v2/js/jquery.js"></script>
  <script src="/public/v2/js/ajax.js"></script>
  <script src="/public/v2/js/blocksit.js"></script>
  <script src="/public/v2/js/nav.js"></script>
  <script src="/ckplayer/ckplayer.js"></script>
</head>
<body>
<script>
    function onBridgeReady() {
        WeixinJSBridge.call('hideOptionMenu');
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

    // function isWeiXin() {
    //     var ua = window.navigator.userAgent.toLowerCase();
    //     console.log(ua);
    //     if (ua.match(/MicroMessenger/i) == 'micromessenger') {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }
    // if (!isWeiXin()) {
    //   window.location.href ='http://www.baidu.com';
    // }
</script>



  
    

<?php if($boxvideo != ''){   ?>


<link rel="stylesheet" href="/public/v1/css/play.css">
<link rel="stylesheet" href="/public/aliplayer/aliplayer-min.css" />
<div class="prism-player videobox" id="video"></div>
<script type="text/javascript" src="/public/aliplayer/aliplayer-min.js"></script>
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
        
        function ckplay(url){
       
            
            
            
            
            
        }
        
        

        function duplay(url){
            // $('#player').attr('src',url);//
           
                }, function (player) {

                }
            )
        }

        ckplay("<?php echo $boxvideo; ?>");
        $(document).on('WeixinJSBridgeReady', () => {
            if (player.tag) {
            player.tag.play();
        }
    });
    })
</script>
<?php } ?>
<nav class="cat_list nav-height" id="navHeight">
  <ul class="clear" id = 'snav'>
  </ul>
</nav>

<div class="swiper-pagination"></div>
<ul class="fix themefix">
  <li class="change"  id = 'changess'>换一批</li>
</ul>
<ul class="fix top" id="top" style="bottom: 130px;">
  <li class="change iconfont icon-fanhuidingbu"></li>
</ul>

<ul class="video_content clear video_content_col2">


</ul>
<input type="hidden" name="page" id ='page' value = '1'>
<input type="hidden" name="cost" id ='cost' value = '<?php echo $c; ?>'>
<input type="hidden" name="toph" id = 'toph' value="<?php echo $show==1?240:0;  ?>">
<div class="mask" id="mask" style="display:none;"></div>
<div class="mask-content" id="mask-content" style="display:none;"></div>

<script src="/public/extend/layui/layui.all.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var layer = layui.layer;
        var hi = $('#toph').val();
        var index = layer.load(3);
        $.ajax({
            url:'/p/home/cost',
            async: false,
            success:function(e){
                layer.close(index);
                var html = '';
                $.each(e.msg,function(index,item){
                    if(item.id == "<?php echo $c; ?>"){
                        html += '<li class="cat_item active"  data-id = "'+item.id+'">' + item.cost + '</li>'

                    }else{
                        html += '<li class="cat_item "  data-id = "'+item.id+'">' + item.cost + '</li>'
                    }
                })
                $('#snav').html(html)
            }
        })

        $('.cat_item').click(function(){
            $('.cat_item').removeClass('active');
            $(this).addClass('active');
            $('#cost').val($(this).attr('data-id'));
            $('#page').val(1);
            $('body,html').animate({
                scrollTop: hi
            }, 0);
            getMore(2)
        })


        var isloading = false
        $("#top").hide()
        var hour = new Date().getHours()
        if (hour > 21 || hour < 8) {
            $('body').addClass('night')
        } else {
            $('body').addClass('day')
        }
        let navHeight = $('#navHeight').offset().top;
        let navFix = $('#navHeight');
        $(window).scroll(function () {
            // if ($(this).scrollTop() > 240) {
            //   navFix.addClass('navFix');
            // } else {
            //   navFix.removeClass('navFix');
            // }
            if ($(window).scrollTop() > 50) {
                $("#top").fadeIn(200);
            } else {
                $("#top").fadeOut(200);
            }
        })
        $("#top").click(function () {
            $('body,html').animate({
                scrollTop: hi
            }, 500);
            return false;
        });

        $('body').on('click', '.video_items', function(e) {
            var price = $(this).attr('price')
            var imgurl = $(this).attr('imgurl')
            var  pl = $(this).attr('pl')
            var  dl = $(this).attr('dl')
            var html = '<div class="image">' +
                '<img src = "' + imgurl + '" />' +
                '</div > ' +
                '<div class="handle">' +
                '<div class="item cancel-mask">取消</div>' +
                //   '<div class="item pay" style="background-color:red" onclick="javascript:window.location.href =\''+dl+'\'">按天' + price + '观看</div>' +
                '<div class="item pay" onclick="javascript:layer.load(3,{shade:0.6,content :\'正在支付\'});window.location.href =\''+pl+'\';">打赏' + price + '观看</div>' +
                '</div>'
            $('#mask-content').html(html)
            $('#mask').show()
            $('#mask-content').show()
        })
        $('.mask-content').on('click', '.cancel-mask', function () {
            $('#mask').hide()
            $('#mask-content').hide()
        });
        $('#mask').click(function (e) {
            $('#mask').hide()
            $('#mask-content').hide()
        })

        function changeThemeColor(params) {
            params = params || '#dc1d33'
            $('.cat_item.active').css('background', params)
            $('.cat_item.ll').css('color', params)
            $('.video_content_col2 .video_item .card').css('background-color', params)
            $('.themefix').css('background-color', params)
            $('.fix.top .change').css('color', params)
        }
        $(window).bind("scroll", function () {
            if ($(document).scrollTop() + $(window).height()
                > $(document).height() - 10 && !isloading) {
                isloading = true;
                getMore(1);
            }
        });
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
                        if(item.urlp == 1){
                            console.log(item.link);
                            html  += ' <li class="video_item" onclick="javascript:window.location.href=\''+item.link+'\'" >';
                        }else{
                            html  += ' <li class="video_item video_items"  price="'+item.price+'"dl = "'+item.urld+'"  pl ="'+item.urlp+'"  imgurl="'+item.cover+'">';
                        }
                        html  += '<a href="javascript:void(0)">'
                        html  += '<div class="video_box iconfont"'
                        html  += 'style="background-image: url(\''+item.cover+'\');">'
                        html  += '</div>'
                        html  += '<div class="card">'+item.paynum+'人付款，价格￥'+item.price+'元</div>'
                        html  += '<div class="handle">'
                        html  += '<h3 class="video_title">'+item.title+'</h3>'
                        html  += '<div class="bottom">'
                        html  += '<span class="desc"><strong>'+item.paynum+'</strong>人付款，价格￥'+item.price+'元</span>'
                        html  += '<button class="play">点击播放</button>'
                        html  += '</div>'
                        html  += '</div>'
                        html  += '</a>'
                        html  += '</li>'
                    })
                    $('#page').val(parseInt($('#page').val()) + 1);
                    isloading = false;
                    if(ss == 1){
                        $('.video_content').append(html)
                    }else{
                        $('.video_content').html(html)
                    }
                }
            })
        }
        $('#changess').click(function(){
            $('#cost').val('all');
            getMore(2);
            $('body,html').animate({
                scrollTop: hi
            }, 0);
        })
        getMore(1)
    })
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