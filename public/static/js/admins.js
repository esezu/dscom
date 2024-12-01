//左侧菜单效果
$('.navlink').click(function (event) {
	var url = $(this).children('a').attr('data-url');
	var title = $(this).find('a').html();
	var index = $(this).children('a').attr('data-id');

	for (var i = 0; i <$('.iframe').length; i++) {
		if($('.iframe').eq(i).attr('tab-id') == index){
			tab.tabChange(index);
			event.stopPropagation();
			return;
		}
	};
	event.stopPropagation();         
})

//菜单隐藏显示
$('#hideBtn').on('click', function() {
	if(!$('#main-layout').hasClass('hide-side')) {
		$('#main-layout').addClass('hide-side');
	} else {
		$('#main-layout').removeClass('hide-side');
	}
});
//遮罩点击隐藏
$('.main-mask').on('click', function() {
	$('#main-layout').removeClass('hide-side');
})
 
 
	function classss(){
		layer.closeAll();
		window.location.reload();
	};
	function del(id){
		layer.confirm('确定要删除吗？', {
		btn: ['确定'] //按钮
		}, 
		function(){
			$.ajax({
				url:'/admins/ad/delmo',
				data:{id,id},
				type:'post',
				dataType:'json',
				success:function(e){
					layer.msg(e.msg);
					if(e.error==0){
						window.location.reload();
					}
				}
			})
		});
	}
 
	function showimg(url){
		var img_infor = "<img onclick='closeAll()' src='" + url + "' />";
		layer.open({    
	        type: 1, 
	        closeBtn: 1,
	        title: false, //不显示标题
	       	//skin: 'layui-layer-nobg', //没有背景色
			closeBtn:0,
	        area:['auto','auto'],   
	shadeClose:true, 
	        //area: [img.width + 'px', img.height+'px'],    
	        content: img_infor //捕获的元素，注意：最好该指定的元素要存放在body最外层，否则可能被其它的相对元素所影响    
	        //cancel: function () {    
	            //layer.msg('图片查看结束！', { time: 5000, icon: 6 });    
	        //}    
    	});    

	} 
	function  closeAll(){
		layer.closeAll();
		window.location.reload();
	}