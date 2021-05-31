<?php $this->load->view('layout/header'); ?>
<link rel="stylesheet" href="/static/extend/css/layui.css"  media="all">
<main class="lyear-layout-content">

    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><h4>权限组管理</h4></div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <div class="layui-btn-container">
								<?php if(checkrole("depart","add")){?>
                                <button class="layui-btn layui-btn-sm add">添加</button>
								<?php } ?>

                            </div>
                            <table class="layui-hide" id="test" lay-filter="test"></table>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</main>
<script src="/static/extend/layui.js" charset="utf-8"></script>

<!--<script type="text/html" id="toolbarDemo">
    <div class="layui-btn-container">
        <button class="layui-btn layui-btn-sm" lay-event="getCheckData">获取选中行数据</button>
        <button class="layui-btn layui-btn-sm" lay-event="getCheckLength">获取选中数目</button>
        <button class="layui-btn layui-btn-sm" lay-event="isAll">验证是否全选</button>
    </div>
</script>-->

<script type="text/html" id="barDemo">
	<?php if(checkrole("depart","edit")){?>
    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
	<?php } ?>
	<?php if(checkrole("depart","editrole")){?>
	<a class="layui-btn layui-btn-xs" lay-event="editrole">权限</a>
	<?php } ?>
	<?php if(checkrole("depart","del")){?>
    <!-- <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a> -->
	<?php } ?>
</script>
<script>

    layui.use(['table'], function() {
        var table = layui.table;


        $('.add').on('click', function() {
            layer.open({
                type: 2,
                title: '添加',
                maxmin: true,
                shadeClose: true, //点击遮罩关闭层
                area: ['800px', '520px'],
                btn: ['确认', '关闭'],
                content: '<?php echo base_url("depart/add"); ?>',
                yes: function(index, layero) {
                    var param = {};
                    var frame = layer.getChildFrame('body', index);
                    var chinesename = frame.find("#chinesename").val();
                    var rolename = frame.find("#rolename").val();
                    var orderno = frame.find("#orderno").val();
                    /*if (catename.length <= 0) {
                     layer.msg('请填写通道名称', {icon: 5});
                     return false;
                     }
                     var sort = frame.find("#sort").val();
                     if (sort.length <= 0) {
                     layer.msg('请填写排序', {icon: 5});
                     return false;
                     }
                     var parent = frame.find("#parent").val();
                     var status = frame.find('input:radio[name="status"]:checked').val();*/
                    param.chinesename = chinesename;
                    param.rolename = rolename;
                    param.orderno = orderno;

                    $.ajax({
                        type: "POST",
                        url: '<?php echo base_url("depart/add"); ?>',
                        dataType: "json",
                        async: false,
                        data: param,
                        success: function(data) {
                            if (data.code == 0) {
                                layer.close(index);
                                layer.msg(data.msg, {
                                    icon: 1,
                                    time: 2000 //2秒关闭（如果不配置，默认是3秒）
                                }, function() {
                                    location.reload();//重载父页表格，参数为表格ID
                                });
                            } else {

                                layer.msg(data.msg, {icon: 5});
                                layer.close(index);
                            }
                        }
                    });
                },
            });
        });
        table.render({
            elem: '#test'
            , url: '<?php echo base_url("depart/index"); ?>',
            height: 650
            , cols: [[
                    {field: 'chinesename', title: '部门名称', width: '20%', },
                    {field: 'rolename', title: '英文名称', width: '20%', },
                    {field: 'orderno', title: '排序', width: "20%"},
                    {fixed: 'right', title: '操作', toolbar: '#barDemo', width: "20%"},
                ]]
            , page: false
        });
        $("#zk").click(function() {
            treetable.expandAll("#test");
        })

        $("#zd").click(function() {
            treetable.foldAll("#test");
        })


        //监听行工具事件
        table.on('tool(test)', function(obj) {
            var data = obj.data;

            if (obj.event === 'del') {
                layer.confirm('真的删除行么', function(index) {
                    $.ajax({
                        url: '<?php echo base_url("depart/del"); ?>',
                        type: "POST",
                        data: {"roleid": data.roleid},
                        dataType: "json",
                        success: function(data) {
                            if (data.code == "0") {

                                obj.del();
                                layer.close(index);
                                layer.msg(data.msg, {
                                    icon: 1,
                                    time: 2000 //2秒关闭（如果不配置，默认是3秒）
                                }, function() {
                                    location.reload();//重载父页表格，参数为表格ID
                                });

                            } else {
                                layer.msg(data.msg, {icon: 5});
                                layer.close(index);
                            }
                        }


                    });
                });
            } else if (obj.event === 'edit') {
                layer.open({
                    type: 2,
                    title: '编辑',
                    maxmin: true,
                    shadeClose: true, //点击遮罩关闭层
                    area: ['800px', '520px'],
                    btn: ['确认', '关闭'],
                    content: '<?php echo base_url("depart/edit"); ?>' + '?roleid=' + data.roleid,
                    yes: function(index, layero) {
                        var param = {};
                        var frame = layer.getChildFrame('body', index);

                        var chinesename = frame.find("#chinesename").val();
                        var rolename = frame.find("#rolename").val();
                        var orderno = frame.find("#orderno").val();
                        var roleid = frame.find("#roleid").val();
                        param.chinesename = chinesename;
                        param.rolename = rolename;
                        param.orderno = orderno;
                        param.roleid = roleid;

                        $.ajax({
                            type: "POST",
                            url: '<?php echo base_url("depart/edit"); ?>',
                            dataType: "json",
                            async: false,
                            data: param,
                            success: function(data) {
                                console.log(data)
                                if (data.code == 0) {
                                    layer.close(index);
                                    layer.msg(data.msg, {
                                        icon: 1,
                                        time: 2000 //2秒关闭（如果不配置，默认是3秒）
                                    }, function() {
                                        location.reload();//重载父页表格，参数为表格ID
                                    });
                                } else {

                                    layer.msg(data.msg, {icon: 5});
                                    layer.close(index);
                                }
                            }
                        });
                    },
                });
            } else if (obj.event === 'editrole') {
                location.href='<?php echo base_url("depart/editrole"); ?>'+ '?roleid=' + data.roleid
            }
        });
    });
</script>

<?php $this->load->view('layout/footer'); ?>
