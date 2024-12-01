<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:54:"/www/wwwroot/dscom/apps/cn/view/promoters/urllist.html";i:1604258956;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>推广链接</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/public/extend/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/public/static/css/public.css" media="all">

    <style>
        html, body {width: 98%;height: 98%;}
        body {background-color: #FFF;overflow:-Scroll;overflow-y:hidden;}

    </style>
</head>
<body style="width: 100%;height: 98%">
<div class="layuimini-main" style="margin-left: 5px;margin-top: 5px;">




    <div class="layui-row">
        <div class="layui-col-xs12">
            <div class="layui-form" id="table-list">

                <div style="background-color: #eee;padding: 15px;">
                    <div class="layui-input-inline">
                        <select name="keys" id ='keys'>
                            <option value="">选择类型</option>
                            <option value="1">推广链接</option>
                            <option value="2">推广盒子</option>
                        </select>
                    </div>

                    <div class="layui-inline">
                        <button class="layui-btn layui-btn-normal" id="searchs">搜索</button>
                    </div>


                    <div class="layui-inline"  style="float: right;padding-right:10px">
                        <button type="button"  class="layui-btn layui-btn-normal " onclick="delall()">全部删除</button>
                    </div>


                </div>
                <table class="layui-table" lay-data="{height: 'full-100',  page: true, limit:16,id:'ajaxData', url:'<?php echo url('promoters/urllist'); ?>'}" lay-filter="ajaxData">
                    <thead>
                    <tr>
                        <th lay-data="{field:'id',width:60}">编号</th>
                        <th lay-data="{field:'url',width:400}">压缩链接</th>
                        <th lay-data="{field:'qrcode',event: 'showimg',width:100}">二维码</th>
                        <th lay-data="{field:'msg',width:550}">备注</th>
                        <th lay-data="{field:'ctime',width:200}">添加时间</th>
                        <th lay-data="{field:'fuck'}">操作</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>








</div>
<script src="/public/static/js/jquery.js" charset="utf-8"></script>
<script src="/public/extend/layui/layui.js" charset="utf-8"></script>
<script type="text/javascript">

    layui.use(['laydate','table','layer'],function(){
        var laydate = layui.laydate;
        var table = layui.table;
        var  layer = layui.layer;
        table.on('tool(ajaxData)', function(obj){
            var data = obj.data;
            if(obj.event =='showimg'){
                layer.open({
                    type: 1,
                    title: false,
                    closeBtn: 0,
                    area: ['500px', '500px'],
                    skin: 'layui-layer-nobg', //没有背景色

                    shadeClose: true,
                    content: data.qrcode
                });
            }
        })
        $('#searchs').on('click', function(){
            table.reload('ajaxData', {
                where: {
                    keys: $('#keys').val(),
                    stime:$('#stime').val(),
                    etime:$('#etime').val(),
                },
                page: {
                    page: 1 //重新从第 1 页开始
                }
            });

        });
        window.delurl = function(id){
            $.ajax({
                url:'<?php echo url("promoters/delurl"); ?>?id='+id,
                dateType:'json',
                success:function(e){
                    layer.msg(e.msg);
                    if(e.code =200){
                        setTimeout(function(){
                            table.reload('ajaxData');
                        },800)
                        return false;
                    }
                }
            })
        }
        window.delall = function(){
            $.ajax({
                url:'<?php echo url("promoters/delurlall"); ?>',
                dateType:'json',
                success:function(e){
                    layer.msg(e.msg);
                    if(e.code =200){
                        setTimeout(function(){
                            table.reload('ajaxData');
                        },800)
                        return false;
                    }
                }
            })
        }
        window.editboxvide = function(box_video_id){
            $.ajax({
                url:'<?php echo url("promoters/getboxvideoinfo"); ?>',
                dateType:'json',
                data:{
                    id : box_video_id
                },
                success:function(e){
                    if(e.code =200){
                        layer.prompt({
                            formType: 2,
                            value: e.data.video,
                            title: '编辑视频链接',
                            btn: ['确定','取消'],
                            btnAlign: 'c',
                        },function(value,index){
                            layer.close(index);
                            if(value == ''){
                                layer.msg('请输入视频链接');
                                return false;
                            }
                            $.ajax({
                                url:'<?php echo url("promoters/editboxvideoinfo"); ?>',
                                dateType:'json',
                                data:{
                                    id : box_video_id,
                                    video : value
                                },
                                success:function(e){
                                    layer.msg(e.msg);
                                }
                            })
                        })
                    }else{
                        layer.msg(e.msg);
                    }
                }
            })
        }


    })

    function copelink(e){
        var textarea = document.createElement("input");//创建input对象
        var currentFocus = document.activeElement;//当前获得焦点的元素
        document.body.appendChild(textarea);//添加元素
        textarea.value = e;
        textarea.focus();
        if(textarea.setSelectionRange)
            textarea.setSelectionRange(0, textarea.value.length);//获取光标起始位置到结束位置
        else
            textarea.select();
        try {
            var flag = document.execCommand("copy");//执行复制
        } catch(eo) {
            var flag = false;
        }
        document.body.removeChild(textarea);//删除元素
        currentFocus.focus();
        if(flag){
            layer.msg('复制成功！');
        }else{
            layer.msg('复制失败！');
        }
    }

</script>

</body>
</html>
