<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:52:"/www/wwwroot/dscom/apps/cn/view/promoters/video.html";i:1619441663;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>片库列表</title>
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
                    <div class="layui-inline">
                        <button type="button"  class="layui-btn layui-btn-normal " onclick="getlink()">推广总链接</button>
                        <button type="button"  class="layui-btn layui-btn-success " onclick="getboxlink()">免费盒子</button>
                    </div>
                    <div class="layui-input-inline">
                        <input type="radio" name="types" value="1" title="短网址" checked="">
                        <input type="radio" name="types" value="2" title="原始链接">
                    </div>
                    <div class="layui-input-inline">
                        <select name="keys" id = 'keys' lay-verify="required" lay-search="">
                            <option value="">请选择类型</option>
                            <?php  foreach($cost as   $v){  ?>
                            <option value="<?php echo $v['id']; ?>"><?php echo $v['cost']; ?></option>
                            <?php  }  ?>
                        </select>
                    </div>
                    <div class="layui-inline">
                        <button class="layui-btn layui-btn-normal" id="searchs">搜索</button>
                    </div>

                </div>
                <table class="layui-table" lay-data="{height: 'full-100',  page: true, limit:16,id:'ajaxData', url:'<?php echo url('promoters/video'); ?>'}" lay-filter="ajaxData">
                    <thead>
                    <tr>
                        <th lay-data="{field:'id',width:100}">编号</th>
                        <th lay-data="{field:'title',width:650}">标题</th>
                        <th lay-data="{field:'cover',width:150,event: 'showimg'}">封面</th>
                        <th lay-data="{field:'cost'}">类型</th>
                        <th lay-data="{field:'ctime'}">修改时间</th>
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
        var layer = layui.layer;
        $('#searchs').on('click', function(){
            table.reload('ajaxData', {
                where: {
                    keys: $("#keys").val()
                },
                page: {
                    page: 1 //重新从第 1 页开始
                }
            });
        });
        table.on('tool(ajaxData)', function(obj){
            var data = obj.data;
            if(obj.event =='showimg'){
                layer.open({
                    type: 1,
                    title:false,
                    skin: 'layui-layer-demo', //样式类名
                    closeBtn: 0, //不显示关闭按钮
                    anim: 2,
                    shadeClose: true, //开启遮罩关闭
                    content: data.cover
                });
            }
        })
        window.getlink = function(id){
            var ty  = $("input[name='types']:checked").val();
            layer.open({
                type: 2,
                title:'推广链接',
                skin: 'layui-layer-demo', //样式类名
                area: ['820px', '600px'], //宽高
                shadeClose: true, //开启遮罩关闭
                content: "<?php echo url('promoters/qrcode'); ?>?id="+id+'&ty='+ty,
                end:function(){
                    table.reload('ajaxData');
                }
            });
        }
        window.getboxlink = function(id){
            var ty  = $("input[name='types']:checked").val();
            layer.prompt({
                formType: 2,
                value: '',
                title: '请输入视频链接',
                btn: ['确定','取消'], //按钮，
                btnAlign: 'c',
            },function(value,index){
                layer.close(index);
                if(value == ''){
                    layer.msg('请输入视频链接');
                    return false;
                }
                layer.open({
                    type: 2,
                    title:'推广链接',
                    skin: 'layui-layer-demo', //样式类名
                    area: ['820px', '600px'], //宽高
                    shadeClose: true, //开启遮罩关闭
                    content: "<?php echo url('promoters/qrcode'); ?>?id="+id+'&ty='+ty+'&boxvideo='+value,
                    end:function(){
                        table.reload('ajaxData');
                    }
                });
            })
        }
    })
</script>

</body>
</html>
