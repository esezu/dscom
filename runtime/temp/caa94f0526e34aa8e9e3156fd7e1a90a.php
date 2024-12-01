<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:48:"/www/wwwroot/dscom/apps/p/view/home/newlsit.html";i:1618818771;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>青青河边草，春风吹又深</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="screen-orientation" content="portrait">
  <meta name="x5-orientation" content="portrait">
  <link rel="stylesheet" type="text/css" href="/public/extend/layui/css/layui.css" />
  <link rel="stylesheet" href="/public/v1/css/iconfont.css">
  <link rel="stylesheet" href="/public/v1/css/index.css">
  <link rel="stylesheet" href="/public/v1/css/notice.css">
  <link rel="stylesheet" href="/public/v1/css/gg.css">
  <style type="text/css" media="all">
    .layui-layer-loading .layui-layer-content{
      padding-top: 25px;
      color: #fff;
    }
  </style>
  <script>
      (function () {
          change();
          function change() {
              document.documentElement.style.fontSize = document.documentElement.clientWidth * 20 / 320 + 'px';
          }
          window.addEventListener('resize', change, false);
      })()
  </script>
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
      //     console.log(ua);//mozilla/5.0 (iphone; cpu iphone os 9_1 like mac os x) applewebkit/601.1.46 (khtml, like gecko)version/9.0 mobile/13b143 safari/601.1
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
  <script src="/public/v1/js/jquery.js"></script>
  <script src="/public/v1/js/ajax.js"></script>
  <script src="/public/v1/js/blocksit.js"></script>
  <script src="/public/v1/js/nav.js"></script>
   <script src="/ckplayer/ckplayer.js"></script>
  <title> </title>
</head>
<body>
<?php if($boxvideo != ''){   ?>
<div class="prism-player videobox" id="video"></div>
<script type="text/javascript" src="/public/js/ckplayer/ckplayer.js" charset="utf-8" data-name="ckplayer"></script>
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
        
		var player = new ckplayer(videoObject);//初始化播放器
        $(document).on('WeixinJSBridgeReady', () => {
            if (player.tag) {
            player.tag.play();
        }
    });
    })
</script>
<?php } ?>
<nav class="cat_list">
  <ul class="clear" id = 'snav'>
  </ul>
</nav>
<div class="nav-height" id="navHeight">
  <div class="bar">
    <input type="text" class="search item" id="search" value = '<?php echo $k; ?>' placeholder="请输入搜索内容">
    <button class="button item" id = 'dosearch' >搜索</button>
    <button class="button item iconfont" id="show-way"></button>
  </div>
</div>
  <ul class="fix">
    <li class="change iconfont" id ="buyy">已购</li>
    <li class="change" id ="shouye">投诉</li>
  </ul>
<input type="hidden" name="page" id ='page' value = '1'>
<ul class="video_content clear" id = 'sss'>
</ul>
<span class="baseline">我是有底线的</span>
<script src="/public/v1/js/index.js?v=1.3"></script>
<script src="/public/extend/layui/layui.all.js"></script>
<script type="text/javascript">
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
                        html += "<li class='cat_item active' onclick='javascript:layer.load(3,{shade:0.6});window.location.href=\"/l/<?php echo $id; ?>/c/"+item.$id+"\"'>"+ item.cost +"</li> "
                    }else{
                        html += "<li class='cat_item' onclick='javascript:layer.load(3,{shade:0.6});window.location.href=\"/l/<?php echo $id; ?>/c/"+item.id+"\"'>"+ item.cost +"</li> "
                    }
                })
                $('#snav').html(html)
            }
        })
    })
    $(function(){
        $('#shouye').click(function(){
            layer.load(3,{shade:0.6});
            window.location.href = '/p/home/tousu';
            return false;
        })
        $('#buyy').click(function(){
            layer.load(3,{shade:0.6});
            window.location.href = '/l/<?php echo $id; ?>/c/buy';
            return false;
        })
        $('#dosearch').click(function(){
            layer.load(3,{shade:0.6});
            var s = $('#search').val();
            window.location.href = "/l/<?php echo $id; ?>/c/"+s
        })
        var s = $('#search').val();
        let lastId = 0
        let isloading = false;
        $(window).bind("scroll", function () {
            if ($(document).scrollTop() + $(window).height() > $(document).height() - 10 && !isloading) {
                isloading = true;
                getlist();
            }
        });
        getlist();
        function getlist(){
            var page = $('#page').val();
            var u = '/p/home/gl?id=<?php echo $id; ?>&c=<?php echo $c; ?>&page='+page;
            $.ajax({
                url:u,
                dataType:'json',
                type:'post',
                success:function(e){
                    var html = '';
                    $.each(e,function(index,item){
                        html += '<li class="video_item">';
                        html += '<a href="'+ item.link+'">';
                        html += '<div class="video_box iconfont" style="background-image: url(\''+item.cover+'\');">';
                        html += '</div>';
                        html += '<div class="handle">';
                        html += '<h3 class="video_title">'+item.title+'</h3>';
                        html += '<div class="bottom">';
                        html += '<span class="desc">已有<strong>' + item.hit +'</strong>人打赏</span>';
                        html += '<button class="play">点击播放</button>';
                        html += '</div>';
                        html += '</div>';
                        html += '</a>';
                        html += '</li>';
                    })
                    $('#page').val(parseInt($('#page').val()) + 1);
                    isloading = false;
                    $('.video_content').append(html).BlocksIt('reload')
                }
            })
        }
        if (JSON.parse('<?php echo $vid; ?>')) {
            showWay = '0'
            localStorage.setItem('showWay', showWay);
            $('.video_content').removeClass('video_content_col1').addClass('video_content_col2')
            $('#show-way').removeClass('icon-caidan').addClass('icon-liebiao')
            $('.video_content_col2').BlocksIt({
                numOfCol: 2,
                offsetX: 5,
                offsetY: 5,
                blockElement: '.video_item'
            });
        } else {
            showWay = '1'
            localStorage.setItem('showWay', showWay);
            $('.video_content').removeClass('video_content_col2').addClass('video_content_col1')
            $('#show-way').removeClass('icon-liebiao').addClass('icon-caidan')
            $('.video_content_col1').BlocksIt({
                numOfCol: 1,
                offsetX: 5,
                offsetY: 5,
                blockElement: '.video_item'
            });
        }



    })
</script>
</body>
</html>