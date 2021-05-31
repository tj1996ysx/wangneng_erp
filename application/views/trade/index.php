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
                    <div class="card-header"><h4>挖矿宝订单</h4></div>
                    <div class="card-body">
                        <form class="form-inline" action="/products/index" method="post" onsubmit="return false;">
                            <div class="form-group">
                                <label class="" for="example-if-email">用户名</label>
                                <input class="form-control" type="text" name="username" id="username"
                                       placeholder="用户名称..">
                            </div>
                            <div class="form-group">
                                <label class="" for="example-if-password">交易类型</label>
                                <select class="form-control" id="tradetype" name="tradetype" size="1">
                                    <option value="">--全部--</option>
                                    <option value="1">买入(做多)</option>
                                    <option value="2">卖出(做空)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="" for="example-if-password">持仓状态</label>
                                <select class="form-control" id="status" name="status" size="1">
                                    <option value="">--全部--</option>
                                    <option value="1">正常</option>
                                    <option value="2">已结束</option>
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
            url: '<?php echo base_url("trade/index"); ?>',
            height: 750,
            size: 'sm'
            , cols: [[
                {field: 'tradeid',title: '交易ID'},
                {field: 'username', title: '用户名称'},
                {field: 'coincode', title: '虚拟币代码'},
                {field: 'avgprice', title: '开仓均价'},
                {field: 'coinratio', title: '杠杆倍数'},
                {field: 'coinnum', title: '持仓数量'},
                {field: 'tradeamount', title: '持仓金额'},
                {
                    field: 'tradetype', title: '交易类型', templet: function (res) {
                        if (res.tradetype == 1) {
                            return "买入";
                        } else if(res.tradetype == 2) {
                            return "卖出";
                        }
                    }
                },
                {
                    field: 'status', title: '交易状态', templet: function (res) {
                        if (res.status == 1) {
                            return "正常";
                        } else if(res.status == 2) {
                            return "已结束";
                        }
                    }
                },
                {
                    field: 'is_sell', title: '是否平仓', templet: function (res) {
                        if (res.selltime != '') {
                            return "已平仓";
                        } else {
                            return "未平仓";
                        }
                    }
                },
                {field: 'profitamount', title: '利润'},
                {field: 'sellprice', title: '平仓均价'},
                {field: 'profitratio', title: '利润百分比'},
                {
                    fixed: 'right', title: '操作', style: 'height:150px;', templet: function (res) {
                        var str = '';
                        return str;
                    }
                },
            ]]
            , page: true
        });

        $("#searchBtn").click(function () {
            var tradetype = $("#tradetype").val()
            var username = $("#username").val()
            var status = $("#status").val();
            dataTable.reload({
                where: {tradetype: tradetype, username: username, status: status},
                page: {curr: 1}
            })
        })

        //监听行工具事件
        table.on('tool(test)', function (obj) {
            var data = obj.data;
        });
    });

</script>

<?php $this->load->view('layout/footer'); ?>
