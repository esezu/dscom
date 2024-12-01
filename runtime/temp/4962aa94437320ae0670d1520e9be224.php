<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:82:"/usr/local/lighthouse/softwares/btpanel/wwwroot/dscom/apps/cn/view/user/index.html";i:1597109370;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>首页</title>
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
        html, body {width: 98%;height: 98%;}
         body {background-color: #eee;}
    </style>
</head>
<body style="width: 100%;height: 98%">
<!--<div class="layuimini-container">-->
<div class="layuimini-main" style="margin-left: 5px;margin-top: 5px;">

    <div class="layui-row layui-col-space15">
        <div class="layui-col-xs12 layui-col-md3">

            <div class="layui-card top-panel">
                <div class="layui-card-header">今日收入</div>
                <div class="layui-card-body">
                    <div class="layui-row layui-col-space5">
                        <div class="layui-col-xs12 layui-col-md12 top-panel-number" id = 'todaymoney'>
                          0.00
                        </div>
                       
                    </div>
                </div>
            </div>

        </div>
        <div class="layui-col-xs12 layui-col-md3">

            <div class="layui-card top-panel">
                <div class="layui-card-header">昨日收入</div>
                <div class="layui-card-body">
                    <div class="layui-row layui-col-space5">
                        <div class="layui-col-xs12 layui-col-md12 top-panel-number" id = 'yesterdaymoney'>
                           0.00
                        </div>
                      
                    </div>
                </div>
            </div>

        </div>
        <div class="layui-col-xs12 layui-col-md3">

            <div class="layui-card top-panel">
                <div class="layui-card-header">今/昨日点击量</div>
                <div class="layui-card-body">
                    <div class="layui-row layui-col-space5">
                        <div class="layui-col-xs12 layui-col-md12 top-panel-number">
                           <span id = 'hit'>0</span> / <span id = 'yesterdayhit'>0</span>
                         </div>
                       
                    </div>
                </div>
            </div>

        </div>
        <div class="layui-col-xs12 layui-col-md3">

            <div class="layui-card top-panel">
                <div class="layui-card-header">总收入</div>
                <div class="layui-card-body">
                    <div class="layui-row layui-col-space5">
                        <div class="layui-col-xs12 layui-col-md12    top-panel-number" id = 'money'>
                            0.00
                        </div>
                        
                    </div>
                </div>
            </div>

        </div>
    </div>

 <div class="layui-row layui-col-space15">
        <div class="layui-col-xs12 layui-col-md3">

            <div class="layui-card top-panel">
                <div class="layui-card-header">今日打赏笔数</div>
                <div class="layui-card-body">
                    <div class="layui-row layui-col-space5">
                        <div class="layui-col-xs12 layui-col-md12 top-panel-number" id= 'todaynum'>
                        0.00
                        </div>
                       
                    </div>
                </div>
            </div>

        </div>
        <div class="layui-col-xs12 layui-col-md3">

            <div class="layui-card top-panel">
                <div class="layui-card-header">昨日打赏笔数</div>
                <div class="layui-card-body">
                    <div class="layui-row layui-col-space5">
                        <div class="layui-col-xs12 layui-col-md12 top-panel-number" id = 'yesterdaynum'>
                           0
                        </div>
                      
                    </div>
                </div>
            </div>

        </div>
        <div class="layui-col-xs12 layui-col-md3">

            <div class="layui-card top-panel">
                <div class="layui-card-header">客户数</div>
                <div class="layui-card-body">
                    <div class="layui-row layui-col-space5">
                        <div class="layui-col-xs12 layui-col-md12 top-panel-number" id = 'usernum'>
                           0
                        </div>
                       
                    </div>
                </div>
            </div>

        </div>
        <div class="layui-col-xs12 layui-col-md3">

            <div class="layui-card top-panel">
                <div class="layui-card-header">总完成订单</div>
                <div class="layui-card-body">
                    <div class="layui-row layui-col-space5">
                        <div class="layui-col-xs12 layui-col-md12    top-panel-number" id = 'allordernum'>
                            0
                        </div>
                        
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="layui-row layui-col-space15">
        <div class="layui-col-xs12 layui-col-md9">
             <div id="container" style="background-color:#ffffff;min-height:300px;padding: 10px"></div>
        </div>
        <div class="layui-col-xs12 layui-col-md3">
            <div id="echarts-pies" style="background-color:#ffffff;min-height:300px;padding: 10px">
                
                <table class="layui-table">
                    <thead>
                    <tr>
                        <th>系统通知</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php  
                        foreach($newslist as $v){ 
                         ?>  
                         <tr>
                          <td  onclick="shownes(<?php echo $v['id']; ?>)" > 
                            <div style="  font-size: 18px;margin-top: 10px;"><?php  echo $v['title']; ?><span style="float: right;;"><?php  echo $v['ctime']; ?></span>
                            </div>
                  
                        </td>
                        </tr>
                        <?php 
                        } 
                         ?> 
                    </tbody>
                </table>


            </div>
        </div>
    </div>


     <div class="layui-row layui-col-space15" >
        <div class="layui-col-xs15 layui-col-md15">
            <div id="containers" style="background-color:#ffffff;min-height:200px;padding: 10px"></div>
       </div>
    </div>



</div>
<!--</div>-->
<script src="/public/static/js/jquery.js" charset="utf-8"></script>
<script src="/public/extend/layui/layui.js" charset="utf-8"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script> 

<script>
$(function(){
    getnum('hit');
    getnum('yesterdayhit');
    getnum('todaymoney');
    getnum('yesterdaymoney');
    getnum('money');
    getnum('todaynum');
    getnum('yesterdaynum');
    getnum('usernum');
    getnum('allordernum');
    function getnum(types){

        $.ajax({
            url:'<?php echo url("getnum"); ?>?ty='+types,
            type:'get',
            dataType:'json',
            success:function(e){
                if(e.code == 200){
                   
                    DynamicNumber.show(types,e.msg);
                }else{

                }
            }
        })
    }
})




var dom = document.getElementById("container");
var myCharts = echarts.init(dom,"walden");
var app = {};
option = null;
option = {
    title: {
        text: '日流水'
    },
    tooltip: {
        trigger: 'axis',
        axisPointer: {
            type: 'cross',
            label: {
                backgroundColor: '#6a7985'
            }
        }
    },
    legend: {
        data: [ '七日收入']
    },
    toolbox: {
        feature: {
            saveAsImage: {}
        }
    },
    grid: {
        left: '3%',
        right: '4%',
        bottom: '3%',
        containLabel: true
    },
    xAxis: [
        {
            type: 'category',
            boundaryGap: false,
            data: <?php echo $date; ?>
        }
    ],
    yAxis: [
        {
            type: 'value'
        }
    ],
    series: [
         
        {
            name: '收入',
            type: 'line',
            stack: '总量',
            areaStyle: {},
            color:'#6fbae1',
            data:<?php echo $money; ?>
        }
    ]
};
 
 myCharts.setOption(option, true);
 

 var dom = document.getElementById("containers");
var myChart = echarts.init(dom,"walden");
var app = {};
option = null;
option = {
    title: {
        text: '24小时统计'
    },
    tooltip: {
        trigger: 'axis'
    },
    legend: {
        data: ['访问量', '订单数']
    },
    grid: {
        left: '3%',
        right: '4%',
        bottom: '3%',
        containLabel: true
    },
    toolbox: {
        feature: {
            saveAsImage: {}
        }
    },
    xAxis: {
        type: 'category',
        boundaryGap: false,
        data:<?php echo $daytime; ?>
    },
    yAxis: {
        type: 'value'
    },
    series: [
        {
            name: '访问量',
            type: 'line',
            stack: '总量',
            data: <?php echo $daymoney; ?>
        },
        {
            name: '订单数',
            type: 'line',
            stack: '总量',
            data: <?php echo $dayorder; ?>
        },
        
        
    ]
};
 myChart.setOption(option, true);
   window.onresize = function () {
            myCharts.resize();
            myChart.resize();
        }
layui.use(['layer'],function(){
    var layer = layui.layer;
})
function shownes(id){

  




  $.ajax({
    url:'<?php echo url("getnews"); ?>?id='+id,
    type:'get',
    dataType:'json',
    success:function(e){
      if(e.code != 1){
        layer.msg('暂无数据');
        return false;
      }
      var title = e.data.title + '  ' + e.data.ctime ;
      var content = e.data.content;
      html ='<div style = "padding:20px,background-color:#fff;font-size:1.25em;margin:20px">'+ content+'</div>'
        layer.open({
          type: 1
          ,title: false //不显示标题栏
          ,closeBtn: false
          ,area: '600px'
          ,id: 'LAY_layuipro' //设定一个id，防止重复弹出
          ,resize: false
          ,btn: ['确定']
          ,btnAlign: 'c'
          ,moveType: 1 //拖拽模式，0或者1
          ,content: html
          ,
        });


    }
  })
} 
</script>
<script type="text/javascript">
     var DynamicNumber = {};
    DynamicNumber.NumberList = {};
    DynamicNumber.show = function (elementId, number) {
        // 1. 已建立过对象直接调用
        var dynaNum = this.NumberList[elementId];
        if (dynaNum) {
            dynaNum.step = 0;
            dynaNum.desNumber = number;
            dynaNum.render();
            return;
        }

        // 2. 创建动态数字绘制对象
        dynaNum = new function (_elementId) {
            this.elementId = _elementId;
            this.preNumber = 0; // 变化过程值
            this.desNumber = 0; // 目标数值，最终显示值

            this.step = 0;      // 变化步长，支持正向反向
            // 绘制过程
            this.render = function () {
                // （1）结束条件
                if (this.preNumber == this.desNumber) {
                    this.step = 0;
                    return;
                }

                // （2）步长设置（计划 2 秒完成 40*50=2000）
                if (this.step == 0) {
                    this.step = Math.round((this.desNumber - this.preNumber) / 40);
                    if (this.step == 0) this.step = (this.desNumber - this.preNumber > 0) ? 1 : -1;
                }

                // （3）走一步
                this.preNumber += this.step;
                if (this.step < 0) {
                    if (this.preNumber < this.desNumber) this.preNumber = this.desNumber;
                } else {
                    if (this.preNumber > this.desNumber) this.preNumber = this.desNumber;
                }

                // （4）显示
                document.getElementById(this.elementId).innerHTML = this.preNumber;

                // （5）每秒绘制 20 次（非精确值）
                var _this = this;
                setTimeout(function () { _this.render(); }, 50);
            };
        } (elementId);

        // 3. 登记绑定元素ID 
        DynamicNumber.NumberList[elementId] = dynaNum;

        // 4. 调用绘制
        dynaNum.step = 0;
        dynaNum.desNumber = number;
        dynaNum.render();
    };
     
</script>
</body>
</html>
