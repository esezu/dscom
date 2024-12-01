
$(document).ready(function () {
  // 菜单吸顶
  let navHeight = $('#navHeight').offset().top;
  console.log(navHeight)
  let navFix = $('#navHeight');
  $(window).scroll(function () {
    if ($(this).scrollTop() > navHeight) {
      navFix.addClass('navFix');
      $('.video_content').css({ 'margin-top': $('#navHeight').height() + 'px' })
    } else {
      navFix.removeClass('navFix');
      $('.video_content').css({ 'margin-top': '0' })
    }
  })
  window.addEventListener('resize', function () {z
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
 
})