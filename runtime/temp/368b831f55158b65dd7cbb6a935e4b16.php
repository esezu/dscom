<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:46:"/www/wwwroot/dscom/apps/p/view/home/tousu.html";i:1603534816;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>投诉</title>
<meta name="viewport" content="width=device-width">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<style>
*{margin:0;padding:0;background-color:#eee}
.title{margin-top:10px;margin-left:10px;margin-bottom:10px;color:#999;font-size:14px}
.body{height:40px;line-height:40px;background-color:#fff;border-bottom:#d8d8d8 1px solid}
.body div{height:40px;line-height:40px;background-color:#fff;padding:0 10px;float:left;color:#333}
.a-label{color:#117afe;font-size:14px;margin-top:10px;margin-left:10px;margin-bottom:10px}
.tsxz{position:absolute;bottom:10px;text-align:center;color:#117afe;font-size:14px;width:100%}
.right{width:20px;height:20px;float:right;margin-top:10px;margin-right:10px}

</style>
<script>
        function next() {
            location.href = '/p/home/tousu2'
        }
    </script>
</head>
<body>
<div class="title">
	请选择投诉该网页的原因:
</div>
<div class="body" onclick="next()">
	<div>
		网页包含欺诈信息（如：假红包）
	</div>
	<img class="right" src="/public/img/left.png" alt="">
</div>
<div class="body" onclick="next()">
	<div>
		网页包含色情信息
	</div>
	<img class="right" src="/public/img/left.png" alt="">
</div>
<div class="body" onclick="next()">
	<div>
		网页包含暴力恐怖信息
	</div>
	<img class="right" src="/public/img/left.png" alt="">
</div>
<div class="body" onclick="next()">
	<div>
		网页包含政治敏感信息
	</div>
	<img class="right" src="/public/img/left.png" alt="">
</div>
<div class="body" onclick="next()">
	<div>
		网页在手机个人隐私信息（如：钓鱼链接）
	</div>
	<img class="right" src="/public/img/left.png" alt="">
</div>
<div class="body" onclick="next()">
	<div>
		网页包含诱导分享/关注性质的内容
	</div>
	<img class="right" src="/public/img/left.png" alt="">
</div>
<div class="body" onclick="next()">
	<div>
		网页可能包含谣言信息
	</div>
	<img class="right" src="/public/img/left.png" alt="">
</div>
<div class="body" onclick="next()">
	<div>
		网页包含赌博信息
	</div>
	<img class="right" src="/public/img/left.png" alt="">
</div>
</body>
</html>