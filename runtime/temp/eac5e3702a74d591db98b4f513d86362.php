<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:54:"/www/wwwroot/dscom/apps/admins/view/user/userinfo.html";i:1597109366;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>详情</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/public/extend/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/public/static/css/public.css" media="all">
    <style>
        .top-panel {
            border: 1px solid #eceff9;
            border-radius: 5px;
            text-align: center;
        }
        .top-panel > .layui-card-body{
            height: 60px;
        }
        .top-panel-number{
            line-height:60px;
            font-size: 30px;
            border-right:1px solid #eceff9;
            border-left: 1px solid #eceff9;
        }
        .top-panel-tips{
            line-height:30px;
            font-size: 12px
        }
    </style>
     <style>
        html, body {width: 98%;}
         body {background-color: #eee;}
    </style>
</head>
<body style="width: 100%;height: 98%">
<!--<div class="layuimini-container">-->
<div class="layuimini-main" style="margin-left: 5px;margin-top: 5px;">
<blockquote class="layui-elem-quote" style="background-color: #fff"><center><h1>代理：<?php echo $uinfo['username']; ?>(id:<?php echo $uinfo['id']; ?>)</h1></center></blockquote>
    <div class="layui-row layui-col-space15">
        <div class="layui-col-xs12 layui-col-md4">

            <div class="layui-card top-panel">
                <div class="layui-card-header">今日收入</div>
                <div class="layui-card-body">
                    <div class="layui-row layui-col-space5">
                        <div class="layui-col-xs12 layui-col-md12 top-panel-number">
                          <?php echo $todaymoney; ?>
                        </div>
                       
                    </div>
                </div>
            </div>

        </div>
        <div class="layui-col-xs12 layui-col-md4">

            <div class="layui-card top-panel">
                <div class="layui-card-header">昨日收入</div>
                <div class="layui-card-body">
                    <div class="layui-row layui-col-space5">
                        <div class="layui-col-xs12 layui-col-md12 top-panel-number">
                           <?php echo $yesterdaymoney; ?>
                        </div>
                      
                    </div>
                </div>
            </div>

        </div>
        <div class="layui-col-xs12 layui-col-md4">

            <div class="layui-card top-panel">
                <div class="layui-card-header">总收入</div>
                <div class="layui-card-body">
                    <div class="layui-row layui-col-space5">
                        <div class="layui-col-xs12 layui-col-md12 top-panel-number">
                           <?php echo $allamount; ?>
                        </div>
                       
                    </div>
                </div>
            </div>

        </div>
        <div class="layui-col-xs12 layui-col-md3">

            <div class="layui-card top-panel">
                <div class="layui-card-header">今日点击量</div>
                <div class="layui-card-body">
                    <div class="layui-row layui-col-space5">
                        <div class="layui-col-xs12 layui-col-md12    top-panel-number">
                            <?php echo $hit; ?>
                        </div>
                            
                    </div>
                </div>
            </div>
        </div>

        <div class="layui-col-xs12 layui-col-md3">

            <div class="layui-card top-panel">
                <div class="layui-card-header">昨日点击量</div>
                <div class="layui-card-body">
                    <div class="layui-row layui-col-space5">
                        <div class="layui-col-xs12 layui-col-md12    top-panel-number">
                            <?php echo $yesterdayhit; ?>
                        </div>
                            
                    </div>
                </div>
            </div>
        </div>

        <div class="layui-col-xs12 layui-col-md3">

            <div class="layui-card top-panel">
                <div class="layui-card-header">总点击量</div>
                <div class="layui-card-body">
                    <div class="layui-row layui-col-space5">
                        <div class="layui-col-xs12 layui-col-md12    top-panel-number">
                            <?php echo $allhit; ?>
                        </div>
                            
                    </div>
                </div>
            </div>
        </div>

        <div class="layui-col-xs12 layui-col-md3">

            <div class="layui-card top-panel">
                <div class="layui-card-header">点击支付率</div>
                <div class="layui-card-body">
                    <div class="layui-row layui-col-space5">
                        <div class="layui-col-xs12 layui-col-md12    top-panel-number">
                            <?php echo $hitbuy; ?>
                        </div>
                            
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-col-xs12 layui-col-md3">

            <div class="layui-card top-panel">
                <div class="layui-card-header">今日订单</div>
                <div class="layui-card-body">
                    <div class="layui-row layui-col-space5">
                        <div class="layui-col-xs12 layui-col-md12    top-panel-number">
                            <?php echo $todaynum; ?>
                        </div>
                            
                    </div>
                </div>
            </div>
        </div>

        <div class="layui-col-xs12 layui-col-md3">

            <div class="layui-card top-panel">
                <div class="layui-card-header">昨日订单</div>
                <div class="layui-card-body">
                    <div class="layui-row layui-col-space5">
                        <div class="layui-col-xs12 layui-col-md12    top-panel-number">
                            <?php echo $yesterdaynum; ?>
                        </div>
                            
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-col-xs12 layui-col-md3">

            <div class="layui-card top-panel">
                <div class="layui-card-header">总订单</div>
                <div class="layui-card-body">
                    <div class="layui-row layui-col-space5">
                        <div class="layui-col-xs12 layui-col-md12    top-panel-number">
                            <?php echo $allordernum; ?>
                        </div>
                            
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-col-xs12 layui-col-md3">

            <div class="layui-card top-panel">
                <div class="layui-card-header">订单支付率</div>
                <div class="layui-card-body">
                    <div class="layui-row layui-col-space5">
                        <div class="layui-col-xs12 layui-col-md12    top-panel-number">
                            <?php echo $buyor; ?>
                        </div>
                            
                    </div>
                </div>
            </div>
        </div>

        <div class="layui-col-xs12 layui-col-md4">

            <div class="layui-card top-panel">
                <div class="layui-card-header">今日户数</div>
                <div class="layui-card-body">
                    <div class="layui-row layui-col-space5">
                        <div class="layui-col-xs12 layui-col-md12    top-panel-number">
                            <?php echo $todayusernum; ?>
                        </div>
                            
                    </div>
                </div>
            </div>
        </div>

        <div class="layui-col-xs12 layui-col-md4">

            <div class="layui-card top-panel">
                <div class="layui-card-header">昨日户数</div>
                <div class="layui-card-body">
                    <div class="layui-row layui-col-space5">
                        <div class="layui-col-xs12 layui-col-md12    top-panel-number">
                            <?php echo $yestadayusernum; ?>
                        </div>
                            
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-col-xs12 layui-col-md4">

            <div class="layui-card top-panel">
                <div class="layui-card-header">总客户数</div>
                <div class="layui-card-body">
                    <div class="layui-row layui-col-space5">
                        <div class="layui-col-xs12 layui-col-md12    top-panel-number">
                            <?php echo $usernum; ?>
                        </div>
                            
                    </div>
                </div>
            </div>
        </div>
       

    </div>


 
</div>
<script src="/public/static/js/jquery.js" charset="utf-8"></script>
<script src="/public/extend/layui/layui.js" charset="utf-8"></script>
 
</body>
</html>
