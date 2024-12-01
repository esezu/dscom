<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:47:"/www/wwwroot/dscom/apps/p/view/home/tousu3.html";i:1603535344;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>投诉</title>
    <meta name="viewport" content="width=device-width">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <style>
        *{
            margin: 0;
            padding: 0;
        }
        .tousu{
            width: 100%;
        }
        .close{
            background-color: #1DAD17;
            color: #ffffff;
            border: none;
            width: calc(100% - 30px);
            height: 45px;
            line-height: 45px;
            margin: 0 15px;
            border-radius:5px;
            font-size: 17px;
            margin-top: 20px;
        }
    </style>
    <script>
        function index() {
            location.href = "<?php echo cookie('__forward__'); ?>";
        }
    </script>
</head>
<body>
<img class="tousu" src="/public/img/tousu.png" alt="">
<button class="close" onclick="index()">关闭</button>
</body>
</html>
