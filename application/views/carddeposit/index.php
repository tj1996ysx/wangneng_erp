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
                    <div class="card-header"><h4>银行卡充值</h4></div>
                    <div class="card-body">
                        <form class="form-inline" action="" method="post" onsubmit="return false;">
                            <div class="form-group">
                                <label class="" for="example-if-email">用户名</label>
                                <input class="form-control" type="text" name="username" id="username"
                                       placeholder="用户名称..">
                            </div>
                            <div class="form-group">
                                <label class="" for="example-if-password">充值状态</label>
                                <select class="form-control" id="depositstatus" name="depositstatus" size="1">
                                    <option value="">--全部--</option>
                                    <option value="0">未成功</option>
                                    <option value="1">成功</option>
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
            url: '<?php echo base_url("vcdeposit/index"); ?>',
            height: 750,
            size: 'sm'
            , cols: [[
                {field: 'depositid',title: '充值ID'},
                {field: 'username', title: '用户名称'},
                {field: 'bankname', title: '银行名称'},
                {field: 'cardno', title: '银行卡号'},
                {field: 'cardname', title: '持卡人姓名'},
                {field: 'depositamount', title: '充值金额'},
                {field: 'depositusdt', title: '转换usdt数量'},
                {field: 'deposittime', title: '充值时间',width: 200},
                {
                    field: 'depositstatus', title: '充值状态', templet: function (res) {
                        if (res.depositstatus == 1) {
                            return "成功";
                        } else if(res.depositstatus == 0) {
                            return "未成功";
                        }
                    }
                },
                {field: 'failreason', title: '充值失败原因'},
                {field: 'customername', title: '客服'},
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
            var username = $("#username").val()
            var depositstatus = $("#depositstatus").val();
            dataTable.reload({
                where: {username: username, depositstatus: depositstatus},
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
