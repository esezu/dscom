<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:46:"/www/wwwroot/dscom/apps/p/view/home/play5.html";i:1618545899;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="screen-orientation" content="portrait">
  <meta name="x5-orientation" content="portrait">
  <link rel="stylesheet" href="/public/v1/css/iconfont.css">
  <link rel="stylesheet" href="/public/v1/css/play.css">
  <link rel="stylesheet" href="/public/v1/css/index.css">
  <link rel="stylesheet" href="/public/v1/css/gg.css">
  <script type="text/javascript" src="/public/js/ckplayer/ckplayer.js" charset="utf-8" data-name="ckplayer"></script>
  <title id = 'title'>视频播放</title>
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
 
</script>


<div class="prism-player videobox" id="video"></div>
  <div class="nav-height" id="navHeight">
    <h4 class="head-title">更多精彩视频推荐</h4>
  </div>
  <ul class="fix">
    <li class="change iconfont" id="show-way"></li>
    <li class="change"  id = 'changess'>首页</li>
  </ul>
  <ul class="video_content clear" id= 'video_content'>
</ul>
  <span class="baseline">--我是有底线的--</span>
  

<script src="/public/static/js/jquery.js" charset="utf-8"></script>
<script src="/public/v1/js/blocksit.js"></script>
<script src="/public/v1/js/nav.js"></script>
<script src="/public/v1/js/play.js?v=1.2"></script>
<script type="text/javascript" src="https://g.alicdn.com/de/prismplayer/2.8.7/aliplayer-min.js"></script>
<script src="/public/extend/layui/layui.js" charset="utf-8"></script>
<script type="text/javascript">









  layui.use(['layer'],function(){
    var layer = layui.layer;
  })
  $(function(){
      
      function ckplay(url){
         var videoObject = {
        container: '#video',
        variable: 'player', 
        
        autoplay: true, 
        poster: '', 
        video:url,
       
        live: false,
 
      
        };
        var player = new ckplayer(videoObject);
          
          
      }
      
      
      
      
      function duplay(url){
        var videoObject = {
			container: '#player-con', //“#”代表容器的ID，“.”或“”代表容器的class
			variable: 'player', //播放函数名称，该属性必需设置，值等于下面的new ckplayer()的对象
			video: url//视频地址
		};
		var player = new ckplayer(videoObject);//初始化播放器
      }



      $.ajax({
        url:"<?php echo url('doplay'); ?>",
        data:{id:"<?php echo $id; ?>"},
        type:"post",
        success:function(e){
          if(e.code == 200){
           ckplay(e.msg.url);
            $('#title').html(e.msg.title);
            return false;
          }
          if(e.code == 400){
            layer.msg(e.msg);
            return false;
          }
        }
      })


      $.ajax({
        url:"<?php echo url('gl'); ?>",
        data:{id:"<?php echo $uid; ?>"},
        type:"post",
        dataType:'json',
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
            html += '<span class="desc">已经付费观看<strong>' + item.hit +'</strong>人</span>';
            html += '<button class="play">点击播放</button>';
            html += '</div>';
            html += '</div>';
            html += '</a>';
            html += '</li>';  
            })
            $('#video_content').append(html);
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
        }
      })




  })
</script>

<script type="text/javascript">
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

(function () {
  change();
  function change() {
    document.documentElement.style.fontSize = document.documentElement.clientWidth * 20 / 320 + 'px';
  }
  window.addEventListener('resize', change, false);
})()

  $('#changess').click(function(){
     window.location.href = '<?php echo $hurl; ?>';
     return false;
  })


</script>
</body>
</html>