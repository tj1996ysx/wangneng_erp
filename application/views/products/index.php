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
                    <div class="card-header"><h4>挖矿宝列表</h4></div>
                    <div class="card-body">

                        <form class="form-inline" action="/products/index" method="post" onsubmit="return false;">
                            <div class="form-group">
                                <label class="" for="example-if-email">产品名称</label>
                                <input class="form-control" type="text" name="productname" id="productname"
                                       placeholder="产品名称..">
                            </div>
                            <div class="form-group">
                                <label class="" for="example-if-password">是否启用</label>
                                <select class="form-control" id="status" name="status" size="1">
                                    <option value="-1">--全部--</option>
                                    <option value="0">未启用</option>
                                    <option value="1">正常</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button class="btn layui-btn" type="submit" id="searchBtn">查询</button>
                            </div>
                            <div class="form-group">
                            <?php if (checkrole("product", "add")) { ?>
                                <button class="btn layui-btn add">添加产品</button>
                            <?php } ?>
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
    <?php if (checkrole("products", "edit")) { ?>
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
    <?php } ?>
    <!--  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a> -->
</script>
<script>
    layui.use(['table', 'upload'], function () {
        var table = layui.table;
        var $ = layui.jquery, upload = layui.upload;
        $('.add').on('click', function () {
            location.href = '<?php echo base_url("products/add"); ?>'
        });
        var dataTable = table.render({
            elem: '#test',
            url: '<?php echo base_url("products/index"); ?>',
            height: 750,
            size: 'sm'
            , cols: [[
                {field: 'productid',title: '产品ID'},
                {field: 'productname', title: '产品名称'},
                {field: 'lowcoin', title: '最低投资币数'},
                {field: 'lowprofit', title: '最低收益百分比'},
                {field: 'highprofit', title: '最高收益百分比'},
                {
                    field: 'productcycle', title: '投资周期', templet: function (res) {
                        return res.productcycle + "天";
                    }
                },
                {field: 'deadlinetime', title: '截止时间'},
                {field: 'addtime', title: '加入时间'},
                {
                    field: 'status', title: '是否启用', templet: function (res) {
                        if (res.status == 1) {
                            return "已启用";
                        } else {
                            return "未启用";
                        }
                    }
                },
                {field: 'username', title: '最后操作人'},
                {
                    fixed: 'right', title: '操作', style: 'height:150px;', templet: function (res) {
                        var str = '';
                        <?php if(checkrole("products", "edit")){?>
                            str += '<a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>';
                        <?php } ?>
                        return str;
                    }
                },
            ]]
            , page: true
        });
        $("#zk").click(function () {
            treetable.expandAll("#test");
        })

        $("#zd").click(function () {
            treetable.foldAll("#test");
        })
        $("#searchBtn").click(function () {
            var productname = $("#productname").val()
            var cateid = $("#cateid").val();
            var sku = $("#sku").val();
            var status = $("#status").val();
            dataTable.reload({
                where: {productname: productname, cateid: cateid, status: status, sku: sku},
                page: {curr: 1}
            })
        })

        openMsg = function (data) {
            var datas = $('#pitureChange' + data).attr('src');
            var data = '<img id="pitureChange" style="width: 720px;height: auto" src="' + datas + '"  >'
            layer.alert(data, {
                title: '图片',
                area: ['720px', '500px']
            });
        }
        //监听行工具事件
        table.on('tool(test)', function (obj) {
            var data = obj.data;
            if (obj.event === 'del') {
                layer.confirm('真的删除么', function (index) {
                    $.ajax({
                        url: '<?php echo base_url("products/del"); ?>',
                        type: "POST",
                        data: {"productid": data.productid},
                        dataType: "json",
                        success: function (data) {
                            if (data.code == "0") {
                                obj.del();
                                layer.close(index);
                                layer.msg(data.msg, {
                                    icon: 1,
                                    time: 2000 //2秒关闭（如果不配置，默认是3秒）
                                }, function () {
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
                location.href = '<?php echo base_url("products/edit"); ?>' + '/' + data.productid
            }
        });
    });

</script>

<?php $this->load->view('layout/footer'); ?>
