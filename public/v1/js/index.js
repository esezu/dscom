
$(document).ready(function () {
  // 菜单吸顶
  let navHeight = $('#navHeight').offset().top;
  let navFix = $('#navHeight');
  $(window).scroll(function () {
    if ($(this).scrollTop() > navHeight) {
      navFix.addClass('navFix');
      $('.video_content').css({'margin-top': '50px'})
    } else {
      navFix.removeClass('navFix');
      $('.video_content').css({ 'margin-top': '0' })
    }
  })
  window.addEventListener('resize', function() {
    let showWay = localStorage.getItem('showWay') || '0'
    if (!JSON.parse(showWay)) {
      $('.video_content').addClass('video_content_col2')
      $('#show-way').addClass('icon-liebiao')
      $('.video_content').BlocksIt({
        numOfCol: 2,
        offsetX: 5,
        offsetY: 5,
        blockElement: '.video_item'
      });
    } else {
      $('#show-way').addClass('icon-caidan')
      $('.video_content').addClass('video_content_col1')
      $('.video_content').BlocksIt({
        numOfCol: 1,
        offsetX: 5,
        offsetY: 5,
        blockElement: '.video_item'
      });
    }
  }, false);
  // 单双列
  let showWay = localStorage.getItem('showWay') || '0'
  if (!JSON.parse(showWay)) {
    $('.video_content').addClass('video_content_col2')
    $('#show-way').addClass('icon-liebiao')
    $('.video_content').BlocksIt({
      numOfCol: 2,
      offsetX: 5,
      offsetY: 5,
      blockElement: '.video_item'
    });
  } else {
    $('#show-way').addClass('icon-caidan')
    $('.video_content').addClass('video_content_col1')
    $('.video_content').BlocksIt({
      numOfCol: 1,
      offsetX: 5,
      offsetY: 5,
      blockElement: '.video_item'
    });
  }
  // 点击单双
  $('#show-way').click(function () {
    console.log(JSON.parse(showWay))
    if (JSON.parse(showWay)) {
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
  // 点击分类
  $('.cat_item').click(function () {
    $('.cat_item').removeClass('active')
    $(this).addClass('active')
    /**
     * 点击分类要干的事
     *  */
  })
  // 搜索框
  let t = null
  $('#search').on('input propertychange', function () {
    let val = $('#search').val()
    // js防抖
    if (t != null) {
      clearTimeout(t)
    }
    t = setTimeout(function () {
      /**
       * 搜索要干的事
       * val 输入框的值 拿去用
       */
    }, 1000);
  });
  // 加载
  
  // let lastId = 0;//记录每一次加载时的最后一条记录id，跟您的排序方式有关。
  // let isloading = false;
  // $(window).bind("scroll", function () {
  //   if ($(document).scrollTop() + $(window).height()
  //     > $(document).height() - 10 && !isloading) {
  //     console.log('加载')
  //     isloading = true;
  //     // getMore();
  //   }
  // });
  // function getRndInteger(min, max) {
  //   return Math.floor(Math.random() * (max - min + 1)) + min;
  // }
  // function getMore() {
  //   let html = ''
  //   console.log(11)
  //   for (let i = 0; i < 10; i++) {
  //     html += `
  //       <li class="video_item">
  //         <a href="./pay.html">
  //           <div class="video_box iconfont" style="background-image: url('https://www.a5xiazai.com/demo/code_pop/18/751/images/img26.jpg');">
  //           </div>
  //           <div class="handle">
  //             <h3 class="video_title">视频名字视频名字视频名字视频名字视频名字</h3>
  //             <div class="bottom">
  //               <span class="desc">已经付费观看<strong>${getRndInteger(2000, 9999)}</strong>人</span>
  //               <button class="play">点击播放</button>
  //             </div>
  //           </div>
  //         </a>
  //       </li>
  //     `
  //   }
  //   isloading = false;
  //   $('.video_content').append(html).BlocksIt('reload')
  // }

  // 隐藏公告（后台关闭公告）
  // $('.nav-height').hide()
})