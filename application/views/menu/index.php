<?php $this->load->view('layout/header'); ?>
<link rel="stylesheet" href="/static/extend/css/layui.css"  media="all">
<main class="lyear-layout-content">

    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><h4>菜单管理</h4></div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <div class="layui-btn-container">
                                <button type="button" class="layui-btn layui-btn-sm" id="zk">全部展开</button>
                                <button type="button" class="layui-btn layui-btn-sm" id="zd">全部折叠</button>
								<?php if(checkrole("menu","add")){?>
                                <button class="layui-btn layui-btn-sm add">添加菜单</button>
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
	<?php if(checkrole("menu","edit")){?>
    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
	<?php } ?>
    <!--    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>-->
</script>
<script>
    layui.config({
        base: '/static/extend/'
    }).extend({
        treetable: 'treetable-lay/treetable',
    });
    layui.use(['table', 'treetable'], function() {
        var table = layui.table;

        var treetable = layui.treetable;
        $('.add').on('click', function() {
            layer.open({
                type: 2,
                title: '添加',
                maxmin: true,
                shadeClose: true, //点击遮罩关闭层
                area: ['800px', '620px'],
                btn: ['确认', '关闭'],
                content: '<?php echo base_url("menu/add"); ?>',
                yes: function(index, layero) {
                    var param = {};
                    var frame = layer.getChildFrame('body', index);
                    var name = frame.find("#name").val();
                    if (name.length <= 0) {
                        layer.msg('请填写菜单名称', {icon: 5});
                        return false;
                    }
                    var sort = frame.find("#sort").val();
                    if (sort.length <= 0) {
                        layer.msg('请填写排序', {icon: 5});
                        return false;
                    }
                    var parent = frame.find("#parent").val();
                    var status = frame.find('input:radio[name="status"]:checked').val();
                    param.name = name;
                    param.action = frame.find("#action").val();
                    param.model = frame.find("#model").val();
                    param.parent = parent;
                    param.sort = sort;
                    param.status = status;
                    $.ajax({
                        type: "POST",
                        url: '<?php echo base_url("menu/add"); ?>',
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
        treetable.render({
            elem: '#test',
            url: '<?php echo base_url("menu/index"); ?>',
            treeColIndex: 0, //树形图标显示在第几列
            treeSpid: '0', //最上级的父级id
            treeIdName: 'id', //id字段的名称
            treePidName: 'parent', //pid字段的名称，父级菜单id
            treeDefaultClose: true, //是否默认折叠
            treeLinkage: true, //父级展开时是否自动展开所有子级
            height: 650
            , cols: [[
                    {field: 'name', title: '菜单名称', width: '20%', },
                    {field: 'model', title: '模块', width: "20%"},
                    {field: 'action', title: '方法', width: "20%"},
                    {field: 'sort', title: '排序', width: "20%"},
                    {field: 'status', title: '状态', width: "10%", templet: function(res) {
                            if (res['status'] == 1) {
                                return '<button type="button" class="layui-btn layui-btn-xs">开启</button>';
                            } else if (res['status'] == 0) {
                                return '<button type="button" class="layui-btn layui-btn-xs layui-btn-danger">关闭</button>';
                            } else {
                                return res['status'];
                            }
                        }
                    },
                    {fixed: 'right', title: '操作', toolbar: '#barDemo', width: "10%"},
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
                        url: '<?php echo base_url("menu/del"); ?>',
                        type: "POST",
                        data: {"id": data.id},
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
                    area: ['800px', '620px'],
                    btn: ['确认', '关闭'],
                    content: '<?php echo base_url("menu/edit"); ?>' + '?id=' + data.id,
                    yes: function(index, layero) {
                        var param = {};
                        var frame = layer.getChildFrame('body', index);
                        var name = frame.find("#name").val();
                        if (name.length <= 0) {
                            layer.msg('请填写菜单名称', {icon: 5});
                            return false;
                        }
                        var sort = frame.find("#sort").val();
                        if (sort.length <= 0) {
                            layer.msg('请填写排序', {icon: 5});
                            return false;
                        }
                        var parent = frame.find("#parent").val();
                        var status = frame.find('input:radio[name="status"]:checked').val();
                        param.name = name;
                        param.action = frame.find("#action").val();
                        param.model = frame.find("#model").val();
                        param.parent = parent;
                        param.sort = sort;
                        param.status = status;
                        param.id =  frame.find("#id").val();
                        $.ajax({
                            type: "POST",
                            url: '<?php echo base_url("menu/edit"); ?>',
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
            }
        });
    });
</script>

<?php $this->load->view('layout/footer'); ?>
