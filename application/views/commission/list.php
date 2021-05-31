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
                    <div class="card-header"><h4>佣金列表</h4></div>
                    <div class="card-body">
                        <form class="form-inline" action="" method="post" onsubmit="return false;">
                            <div class="form-group">
                                <label class="" for="example-if-email">用户姓名</label>
                                <input class="form-control" type="text" name="name" id="name" value="">
                            </div>
                            <div class="form-group">
                                <label class="" for="example-if-password">支付状态</label>
                                <select class="form-control" id="paystatus" name="paystatus">
                                    <option value="">全部</option>
                                    <option value="1">已缴纳</option>
                                    <option value="0">未缴纳</option>
                                </select>
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
<script>
    layui.use(['table', 'upload'], function () {
        var table = layui.table;
        var $ = layui.jquery, upload = layui.upload;
        var dataTable = table.render({
            elem: '#test',
            toolbar: '#barDemo',
            url: '<?php echo base_url("commission/index"); ?>',
            // height: 750,
            // cellMinWidth: 150,
            size: 'sm'
            , cols: [[
                {field: 'comid', title: 'ID'},
                {field: 'name', title: '用户姓名'},
                {field: 'settlemonth',title: '结算月份'},
                {field: 'comamount', title: '佣金金额'},
                {field: 'comratio', title: '佣金比例'},
                {field: 'profitamount', title: '收益金额'},
                {field: 'paytime', title: '支付时间'},
                {
                    field: 'paystatus', title: '支付状态', templet: function (res) {
                        if (res.withdrawstatus == 1) {
                            return "已缴纳";
                        } else {
                            return "未缴纳";
                        }
                    }
                },
                {
                    fixed: 'right', title: '操作', style: 'height:150px;', templet: function (res) {
                        var btn = '';
                        return btn;
                    }
                },
            ]]
            , page: true
        });

        $("#searchBtn").click(function () {
            var name = $("#name").val();
            var paystatus = $("#paystatus").val();
            dataTable.reload({
                where: {name: name,paystatus:paystatus},
                page: {curr: 1}
            })
        })
        table.on('toolbar(test)', function (obj) {
        });

        //监听行工具事件
        table.on('tool(test)', function (obj) {
        });
    });
</script>

<?php $this->load->view('layout/footer'); ?>
