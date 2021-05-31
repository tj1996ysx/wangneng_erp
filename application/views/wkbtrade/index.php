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
                                <label class="" for="example-if-email">产品名称</label>
                                <input class="form-control" type="text" name="productname" id="productname"
                                       placeholder="产品名称..">
                            </div>
                            <div class="form-group">
                                <label class="" for="example-if-email">用户名</label>
                                <input class="form-control" type="text" name="username" id="username"
                                       placeholder="用户名称..">
                            </div>
                            <div class="form-group">
                                <label class="" for="example-if-password">交易状态</label>
                                <select class="form-control" id="tradestatus" name="tradestatus" size="1">
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
            url: '<?php echo base_url("wkbtrade/index"); ?>',
            height: 750,
            size: 'sm'
            , cols: [[
                {field: 'tradeid',title: '订单ID'},
                {field: 'username', title: '用户名称'},
                {field: 'productname', title: '挖矿宝产品名称'},
                {field: 'groupno', title: '矿机组编号'},
                {field: 'coinnum', title: '买入数量'},
                {field: 'tradeamount', title: '转换usdt数量'},
                {field: 'tradetime', title: '交易时间', width:200},
                {field: 'overtime', title: '结束时间',width:200},
                {field: 'expectprofit', title: '预期收益'},
                {
                    field: 'tradestatus', title: '交易状态', templet: function (res) {
                        if (res.tradestatus == 1) {
                            return "正常";
                        } else if(res.tradestatus == 2) {
                            return "已结束";
                        }
                    }
                },
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
            var productname = $("#productname").val()
            var username = $("#username").val()
            var tradestatus = $("#tradestatus").val();
            dataTable.reload({
                where: {productname: productname, username: username, tradestatus: tradestatus},
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
