/*
 * @Date: 2020-07-06 21:31:45
 * @LastEditors: zhiqinfff
 * @LastEditTime: 2020-07-09 18:47:06
 * @FilePath: /191225-10-01/js/play2.js
 */ 

$(document).ready(function () {
  var isloading = false
  $("#top").hide()
  var hour = new Date().getHours()
  if (hour > 21 || hour < 8) {
    $('body').addClass('night')
  } else {
    $('body').addClass('day')
  }
  console.log(hour)
  // 菜单吸顶
  let navHeight = $('#navHeight').offset().top;
  // 轮播图
  new Swiper('.gg-container', {
    spaceBetween: 30,
    centeredSlides: true,
    autoplay: {
      delay: 2500,
      disableOnInteraction: false,
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    }
  });
  new Swiper('.cat-container', {
    spaceBetween: 30,
    centeredSlides: true,
    pagination: {
      el: '.swiper-pagination2',
      clickable: true,
    }
  });
  
  let navFix = $('#navHeight');
  $(window).scroll(function () {
    if ($(this).scrollTop() > 240) {
      navFix.addClass('navFix');
      $('.gg-container').css({ 'margin-top': $('#navHeight').height() + 20 + 'px' })
    } else {
      navFix.removeClass('navFix');
      $('.gg-container').css({ 'margin-top': '0' })
    }
    if ($(window).scrollTop() > 50) {
      $("#top").fadeIn(200);
    } else {
      $("#top").fadeOut(200);
    }
  })
  $("#top").click(function () {
    $('body,html').animate({
      scrollTop: 240
    }, 500);
    return false;
  });
  
  $('body').on('click', '.video_item', function(e) {
    var price = $(this).attr('price')
    var imgurl = $(this).attr('imgurl')
    console.log(imgurl, price)
    var html = '<div class="image">' + 
      '<img src = "' + imgurl + '" />' + 
      '</div > ' + 
      '<div class="handle">' + 
      '<div class="item cancel-mask">取消</div>' + 
      '<div class="item pay">付款' + price + '观看</div>' + 
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
  var player = new Aliplayer({
    "id": "player-con",
    "source": "http://1252093142.vod2.myqcloud.com/4704461fvodcq1252093142/48c8a9475285890781000441992/playlist.m3u8",
    "width": "100%",
    "height": "240px",
    "autoplay": true,
    "isLive": false,
    "rePlay": true,
    "playsinline": true,
    "preload": true,
    "controlBarVisibility": "hover",
    "useH5Prism": true
  }, function (player) {
    player._switchLevel = 0;
  }
  );
  $(document).on('WeixinJSBridgeReady', () => {
    if (player.tag) {
      player.tag.play();
    }
  });
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
      getMore();
    }
  });
  function getMore() {
    let html = ''
    console.log(11)
    for (let i = 0; i < 10; i++) {
      html += `
        <li class="video_item" price="2.33" imgurl="https://www.a5xiazai.com/demo/code_pop/18/751/images/img26.jpg">
          <a href="javascript:void(0)">
            <div class="video_box iconfont"
              style="background-image: url('https://www.a5xiazai.com/demo/code_pop/18/751/images/img26.jpg');">
            </div>
            <div class="card">已有1213人付费观看</div>
            <div class="handle">
              <h3 class="video_title">视频名字视频名字视频名字视频名字视频名字</h3>
              <div class="bottom">
                <span class="desc">已经付费观看<strong>888</strong>人</span>
                <button class="play">点击播放</button>
              </div>
            </div>
          </a>
        </li>
      `
    }
    isloading = false;
    $('.video_content').append(html).BlocksIt('reload')
  }
  // 传什么颜色，主题色就是什么颜色 ，十六进制颜色码
  changeThemeColor()
})