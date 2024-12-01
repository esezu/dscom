<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:86:"/usr/local/lighthouse/softwares/btpanel/wwwroot/dscom/apps/admins/view/home/index.html";i:1618536382;}*/ ?>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?>总后台</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/public/layui/js/layui/css/layui.css" >
    <link rel="stylesheet" href="/public/layui/css/admin.css" >
    <link rel="stylesheet" href="/public/layui/css/plugins/viewer/viewer.css"><!--viewer图片查看器-->
    <link rel="stylesheet" href="/public/layui/css/font-awesome.min.css"><!--fontAwesome图标库-->
    
    <!--<link rel="stylesheet" href="/static/css/plugins/animate/animate.min.css" >-->
 
    <link rel="stylesheet" href="/public/layui/css/plugins/formSelects/formSelects-v4.css" ><!--select多选组件-->
   <script type="text/javascript" src="/public/layui/js/plugins/cropper/Crop.js"></script>
  
    <link rel="stylesheet" href="/public/layui/css/plugins/toastr/toastr.css" ><!--toastr通知组件-->
</head>

<body class="layui-layout-body">
<div id="LAY_app">
    <div class="layui-layout layui-layout-admin">
        <div class="layui-header">
            <!-- 头部区域 -->
            <ul class="layui-nav layui-layout-left">
                <li class="layui-nav-item layadmin-flexible" lay-unselect="">
                    <a href="javascript:;" layadmin-event="flexible" title="侧边伸缩">
                        <i class="layui-icon layui-icon-shrink-right" id="LAY_app_flexible"></i>
                    </a>
                </li>
                
                <li class="layui-nav-item" lay-unselect="">
                    <a href="javascript:;" layadmin-event="refresh" title="刷新">
                        <i class="layui-icon layui-icon-refresh-3"></i>
                    </a>
                </li>
                
            </ul>
            <ul class="layui-nav layui-layout-right" lay-filter="layadmin-layout-right" id="view">
			<li class="layui-nav-item layui-hide-xs" lay-unselect="">
                    <a href="javascript:;" layadmin-event="note" title="便签">
                        <i class="layui-icon layui-icon-note"></i>
                    </a>
                </li>
                <li class="layui-nav-item layui-hide-xs" lay-unselect="">
                    <a href="javascript:;" layadmin-event="fullscreen" title="全屏">
                        <i class="layui-icon layui-icon-screen-full"></i>
                    </a>
                </li>
                
                <li class="layui-nav-item" lay-unselect="">
                    <a href="javascript:;">
                        <cite>admin</cite>
                        <span class="layui-nav-more"></span></a>
                    <dl class="layui-nav-child">
                        
                        <dd><a href='javascript:;' onclick="repassword()"><i class="fa fa-user-circle-o"></i> 修改资料</a></dd>
                        
                        <hr>
                        <dd  style="text-align: center;"><a  href="<?php echo url('home/logout'); ?>"><i class="fa fa-sign-out"></i> 退出</a></dd>
                    </dl>
                </li>

                <li class="layui-nav-item layui-hide-xs" lay-unselect="">
                    <a href="javascript:;" layadmin-event="theme" title="皮肤">
                        <i class="layui-icon layui-icon-theme"></i>
                    </a>
                </li>
                
                <li class="layui-nav-item layui-show-xs-inline-block layui-hide-sm" lay-unselect="">
                    <a href="javascript:;" layadmin-event="more"><i class="layui-icon layui-icon-more-vertical"></i></a>
                </li>
            </ul>
        </div>

       <div class="layui-side layui-side-menu">
            <div class="layui-side-scroll">
                <div class="layui-logo">
                    <span><?php echo $title; ?>总后台</span>
                </div>
			  <ul class="layui-nav layui-nav-tree " id="LAY-system-side-menu"  lay-filter="layadmin-system-side-menu" lay-shrink="all">
			   <li data-name="home" class="layui-nav-item">
                <a href="javascript:;" lay-tips="资源管理" lay-direction="2">
                 <i class="layui-icon layui-icon-template-1"></i>
                 <cite>资源管理</cite>
                 <span class="layui-nav-more"></span>
                  </a>
                   <dl class="layui-nav-child">
                   <dd data-name="console"><a lay-href="<?php echo url('video/index'); ?>">资源列表</a></dd>
                      </dl>
                    </li>
				
				
				<li data-name="home" class="layui-nav-item">
                <a href="javascript:;" lay-tips="分类管理" lay-direction="2">
                 <i class="layui-icon layui-icon-template-1"></i>
                 <cite>分类管理</cite>
                 <span class="layui-nav-more"></span>
                  </a>
                   <dl class="layui-nav-child">
                   <dd data-name="console"><a lay-href="<?php echo url('video/classl'); ?>">分类列表</a></dd>
                      </dl>
                    </li>
				
				<li data-name="home" class="layui-nav-item">
                <a href="javascript:;" lay-tips="扣量管理" lay-direction="2">
                 <i class="layui-icon layui-icon-shrink-right"></i>
                 <cite>扣量管理</cite>
                 <span class="layui-nav-more"></span>
                  </a>
                   <dl class="layui-nav-child">
                   <dd data-name="console"><a lay-href='<?php echo url("cus/index"); ?>'>扣量列表</a></dd>
				   <dd data-name="console"><a lay-href='<?php echo url("cus/order"); ?>'>扣量订单</a></dd>
                      </dl>
                    </li>
					
				<li data-name="home" class="layui-nav-item">
                <a href="javascript:;" lay-tips="代理管理" lay-direction="2">
                 <i class="layui-icon layui-icon-user"></i>
                 <cite>代理管理</cite>
                 <span class="layui-nav-more"></span>
                  </a>
                   <dl class="layui-nav-child">
                   <dd data-name="console"><a lay-href='<?php echo url("user/index"); ?>'>代理列表</a></dd>
				 
                      </dl>
                    </li>
					
					
				<li data-name="home" class="layui-nav-item">
                <a href="javascript:;" lay-tips="域名管理" lay-direction="2">
                 <i class="layui-icon layui-icon-link"></i>
                 <cite>域名管理</cite>
                 <span class="layui-nav-more"></span>
                  </a>
                   <dl class="layui-nav-child">
                   <dd data-name="console"><a lay-href="<?php echo url('ename/index'); ?>">入口域名</a></dd>
				   <dd data-name="console"><a lay-href="<?php echo url('ename/ground'); ?>">落地域名</a></dd>
				   <dd data-name="console"><a lay-href="<?php echo url('kuaizhan/index'); ?>">快站域名</a></dd>
				 
                      </dl>
                    </li>
					
                <li data-name="home" class="layui-nav-item">
                <a href="javascript:;" lay-tips="公告管理" lay-direction="2">
                 <i class="layui-icon layui-icon-speaker"></i>
                 <cite>公告管理</cite>
                 <span class="layui-nav-more"></span>
                  </a>
                   <dl class="layui-nav-child">
                   <dd data-name="console"><a lay-href="<?php echo url('news/index'); ?>">公告列表</a></dd>
                      </dl>
                    </li>
			    
				<li data-name="home" class="layui-nav-item">
                <a href="javascript:;" lay-tips="财务管理" lay-direction="2">
                 <i class="layui-icon layui-icon-rmb"></i>
                 <cite>财务管理</cite>
                 <span class="layui-nav-more"></span>
                  </a>
                   <dl class="layui-nav-child">
                   <dd data-name="console"><a lay-href="<?php echo url('user/sys'); ?>">收入详情</a></dd>
				    <dd data-name="console"><a lay-href="<?php echo url('user/order'); ?>">订单列表</a></dd>
					 <dd data-name="console"><a lay-href="<?php echo url('user/getmoney'); ?>">提现管理</a></dd>
                      </dl>
                    </li>
			    <li data-name="home" class="layui-nav-item">
                <a href="javascript:;" lay-tips="网站设置" lay-direction="2">
                 <i class="layui-icon layui-icon-set"></i>
                 <cite>网站设置</cite>
                 <span class="layui-nav-more"></span>
                  </a>
                   <dl class="layui-nav-child">
                   <dd data-name="console"><a lay-href="<?php echo url('systems/index'); ?>">平台设置</a></dd>
				    <dd data-name="console"><a lay-href="<?php echo url('systems/mpwxlist'); ?>">公众号设置</a></dd>
					 <dd data-name="console"><a lay-href="<?php echo url('systems/paylist'); ?>">支付配置</a></dd>
					  <dd data-name="console"><a lay-href="<?php echo url('systems/payedit'); ?>">支付选择</a></dd>
                      </dl>
                    </li>
            </ul>
            </div>
        </div>
		<div class="layadmin-pagetabs" id="LAY_app_tabs">
            <div class="layui-icon layadmin-tabs-control layui-icon-prev" layadmin-event="leftPage"></div>
            <div class="layui-icon layadmin-tabs-control layui-icon-next" layadmin-event="rightPage"></div>
            <div class="layui-icon layadmin-tabs-control layui-icon-down">
                <ul class="layui-nav layadmin-tabs-select" lay-filter="layadmin-pagetabs-nav">
                    <li class="layui-nav-item" lay-unselect="">
                        <a href="javascript:;"><span class="layui-nav-more"></span></a>
                        <dl class="layui-nav-child layui-anim-fadein">
                            <dd layadmin-event="closeThisTabs"><a href="javascript:;">关闭当前标签页</a></dd>
                            <dd layadmin-event="closeOtherTabs"><a href="javascript:;">关闭其它标签页</a></dd>
                            <dd layadmin-event="closeAllTabs"><a href="javascript:;">关闭全部标签页</a></dd>
                        </dl>
                    </li>
                </ul>
            </div>
            <div class="layui-tab" lay-unauto="" lay-allowclose="true" lay-filter="layadmin-layout-tabs">
                <ul class="layui-tab-title" id="LAY_app_tabsheader">
                    <li lay-id="" lay-attr="" class="layui-this"><i class="layui-icon layui-icon-home"></i> 首页<i class="layui-icon layui-unselect layui-tab-close">ဆ</i>
                    </li>
                </ul>
            </div>
        </div>


        <!-- 主体内容 -->
        <div class="layui-body" id="LAY_app_body">
            <div class="layadmin-tabsbody-item layui-show">
                <iframe src="<?php echo url('home/tt'); ?>" frameborder="0" class="layadmin-iframe"></iframe>
            </div>
        </div>

        <!-- 辅助元素，一般用于移动设备下遮罩 -->
        <div class="layadmin-body-shade" layadmin-event="shade"></div>
    </div>
</div>
<script src="/public/layui/js/jquery.min.js"></script>
<script src="/public/layui/js/layui/layui.js"></script>
<script>
    layui.config({
        base: '/public/layui/src/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
        , formSelects: 'formSelects-v4'
        , dropdown: 'dropdown'
    }).use(['index','dropdown','formSelects']),function(){
        var formSelects = layui.formSelects
    };
	
function repassword(){
    layer.open({
        type: 2,
        title:'修改密码',
        skin: 'layui-layer-demo', //样式类名
        area: ['820px', '95%'], //宽高
        shadeClose: true, //开启遮罩关闭
        content: "<?php echo url('repassword'); ?>"
    });
}
</script>
</body>
</html>