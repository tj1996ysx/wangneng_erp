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
                    <div class="card-header"><h4>币种列表</h4></div>
                    <div class="card-body">

                        <form class="form-inline" action="/products/index" method="post" onsubmit="return false;">
                            <div class="form-group">
                                <label class="" for="example-if-email">电话号码</label>
                                <input class="form-control" type="text" name="coincode" id="coincode">
                            </div>
                            <div class="form-group">
                                <button class="btn layui-btn" type="submit" id="searchBtn">查询</button>
                            </div>
                            <div class="form-group">
                                <button class="layui-btn layui-btn-normal" type="submit" id="searchClear">清除</button>
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
    <?php if (checkrole("coin", "add")) { ?>
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
            url: '<?php echo base_url("coin/index"); ?>',
            // height: 750,
            // cellMinWidth: 150,
            size: 'sm'
            , cols: [[
                {field: 'coinid', title: '虚拟币ID'},
                {field: 'coincode', title: '币种代码'},
                {
                    field: 'coinstatus', title: '币种状态', templet: function (res) {
                        if (res.coinstatus == 1) {
                            return "正常";
                        } else {
                            return "未启用";
                        }
                    }
                },
                {
                    field: 'recommand', title: '币种状态', templet: function (res) {
                        if (res.recommand == 1) {
                            return "推荐";
                        } else {
                            return "不推荐";
                        }
                    }
                },
                {field: 'username', title: '上次操作人'},
                {
                    fixed: 'right', title: '操作', style: 'height:150px;', templet: function (res) {
                        var btn = '';
                        <?php if (checkrole("coin", "edit")) { ?>
                        btn += '<a class="layui-btn" lay-event="edit">编辑</a>';
                        <?php } ?>
                        <?php if (checkrole("coin", "delete")) { ?>
                        btn += '<a class="layui-btn layui-btn-danger" lay-event="delete">删除</a>';
                        <?php } ?>
                        return btn;
                    }
                },
            ]]
            , page: true
        });

        $("#searchBtn").click(function () {
            var coincode = $("#coincode").val()
            dataTable.reload({
                where: {coincode: coincode},
                page: {curr: 1}
            })
        })

        $("#searchClear").click(function () {
            $("#username").val("");
            dataTable.reload({
                where: {},
            });
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
                    content: '<?php echo base_url("coin/add"); ?>',
                    yes: function (index, layero) {
                        var body = layer.getChildFrame('body', index);//获取layer主体
                        body.find("#coin_add").click();
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
                            url: '<?php echo base_url("coin/delete"); ?>',
                            type: "POST",
                            data: {"coinid": data.coinid},
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
                    content: '<?php echo base_url("coin/edit").'/'?>'+data.coinid
                };
                var layer_btn_el = 'coin_edit';
                layerOpen(layer,param,layer_btn_el,dataTable);
                //layer.open({
                //    type: 2,
                //    title: '修改',
                //    maxmin: true,
                //    area: ['800px', '495px'],
                //    btn: ['确认', '取消'],
                //    content: '<?php //echo base_url("coin/edit").'/'?>//'+data.coinid,
                //    yes: function (index, layero) {
                //        var body = layer.getChildFrame('body', index);//获取layer主体
                //        body.find("#coin_edit").click();
                //    },
                //    end: function () {
                //        dataTable.reload({
                //            where: {},
                //        });
                //    }
                //})
            }
        });
    });
</script>

<?php $this->load->view('layout/footer'); ?>
