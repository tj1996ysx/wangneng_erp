<?php $this->load->view('layout/header'); ?>
<link rel="stylesheet" href="/static/extend/css/layui.css" media="all">
<style type="text/css">
    .layui-table-cell {
        text-align: center;
        height: auto;
        white-space: normal;
    }
</style>
<style type="text/css">
    td div.layui-table-cell {
        height: 50px !important;
        line-height: 50px !important;
        position: relative;
        text-overflow: ellipsis;
        white-space: nowrap;
        box-sizing: border-box;
        padding: 0px 15px;
        overflow: hidden;
    }
</style>
<main class="lyear-layout-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><h4>客服列表</h4></div>
                    <div class="card-body">
                        <form class="form-inline" action="" method="post" onsubmit="return false;">
                            <div class="form-group">
                                <label class="" for="example-if-email">客服账号</label>
                                <input class="form-control" type="text" name="devicecode" id="devicecode" value="">
                            </div>
                            <div class="form-group">
                                <button class="btn layui-btn" type="submit" id="searchBtn">查询</button>
                            </div>
                        </form>
                        <table class="layui-hide" id="test" lay-filter="test"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>

</main>
<script src="/static/extend/layui.js" charset="utf-8"></script>
<script type="text/html" id="barDemo">
    <?php if (checkrole("services", "add")) { ?>
        <a class="layui-btn" lay-event="add">新增</a>
    <?php } ?>
    <!--  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a> -->
</script>
<script>
    layui.use(['table', 'upload'], function () {
        var table = layui.table;
        var $ = layui.jquery, upload = layui.upload;
        var dataTable = table.render({
            elem: '#test',
            toolbar: '#barDemo',
            url: '<?php echo base_url("services/index"); ?>',
            // height: 750,
            // cellMinWidth: 150,
            size: 'sm'
            , cols: [[
                {field: 'customerid', title: 'ID'},
                {field: 'customername', title: '客服账号'},
                {
                    field: 'cusstatus', title: '客服号状态', templet: function (res) {
                        if(res.cusstatus == 0){
                            return '未启用';
                        }else if(res.cusstatus == 1){
                            return '已启用';
                        }
                    }
                },
                {field: 'customertype', title: '账户类型'},
                {field: 'linkaddress', title: '链接地址'},
                {field: 'username', title: '最后操作人'},
                {
                    fixed: 'right', title: '操作', style: 'height:150px;', templet: function (res) {
                        var btn = '';
                        <?php if (checkrole("services", "edit")) { ?>
                        btn += '<a class="layui-btn" lay-event="edit">编辑</a>'
                        <?php } ?>
                        <?php if (checkrole("services", "delete")) { ?>
                        btn += '<a class="layui-btn layui-btn-danger" lay-event="delete">删除</a>'
                        <?php } ?>
                        return btn;
                    }
                },
            ]]
            , page: true
        });

        $("#searchBtn").click(function () {
            var devicecode = $("#devicecode").val();
            dataTable.reload({
                where: {devicecode: devicecode},
                page: {curr: 1}
            })
        })
        table.on('toolbar(test)', function (obj) {
            if (obj.event == 'add') {
                layer.open({
                    type: 2,
                    title: '添加',
                    maxmin: true,
                    shadeClose: true, //点击遮罩关闭层
                    area: ['800px', '495px'],
                    btn: ['确认', '取消'],
                    content: '<?php echo base_url("services/add"); ?>',
                    yes: function (index, layero) {
                        var body = layer.getChildFrame('body', index);//获取layer主体
                        body.find("#services_add").click();
                    },
                    end: function () {
                        dataTable.reload({
                            where: {},
                        });
                    }
                })
            }
        });

        //监听行工具事件
        table.on('tool(test)', function (obj) {
            var data = obj.data;
            if (obj.event === 'delete') {
                layer.open({
                    type: 0,
                    title:'删除',
                    shadeClose: true, //点击遮罩关闭层
                    btn: ['确认', '取消'],
                    content: '确认删除么?',
                    yes: function (index, layero) {
                        $.ajax({
                            url: '<?php echo base_url("services/delete"); ?>',
                            type: "POST",
                            data: {"customerid": data.customerid},
                            dataType: "json",
                            success: function (data) {
                                if (data.code == "0") {
                                    layer.msg(data.msg, {
                                        icon: 1,
                                        time: 2000 //2秒关闭（如果不配置，默认是3秒）
                                    }, function () {
                                        layer.close(index);
                                    });

                                } else {
                                    layer.msg(data.msg, {icon: 5, time: 2000}, function () {
                                        layer.close(index);
                                    });
                                }
                            }
                        });
                    },
                    end: function () {
                        dataTable.reload({
                            where: {},
                        });
                    }
                });
            }else if(obj.event === 'edit'){
                var param = {
                    type:2,
                    content: '<?php echo base_url("services/edit").'/'?>'+data.customerid
                };
                var layer_btn_el = 'services_edit';
                layerOpen(layer,param,layer_btn_el,dataTable);
            }
        });
    });
</script>

<?php $this->load->view('layout/footer'); ?>
