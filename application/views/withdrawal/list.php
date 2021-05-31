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
                    <div class="card-header"><h4>提现列表</h4></div>
                    <div class="card-body">
                        <form class="form-inline" action="" method="post" onsubmit="return false;">
                            <div class="form-group">
                                <label class="" for="example-if-email">提现人姓名</label>
                                <input class="form-control" type="text" name="name" id="name" value="">
                            </div>
                            <div class="form-group">
                                <label class="" for="example-if-password">提现状态</label>
                                <select class="form-control" id="withdrawstatus" name="withdrawstatus">
                                    <option value="">全部</option>
                                    <option value="1">成功</option>
                                    <option value="0">失败</option>
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
            url: '<?php echo base_url("withdrawal/index"); ?>',
            // height: 750,
            // cellMinWidth: 150,
            size: 'sm'
            , cols: [[
                {field: 'withdrawid', title: '提现ID'},
                {field: 'name', title: '用户姓名'},
                {
                    title: '银行信息', templet: function (res) {
                        return res.country + res.bankname + res.cardno + res.cardname;
                    }
                },
                {field: 'swiftcode', title: 'SWIFT代码'},
                {field: 'withdrawusdt', title: '提现数量'},
                {field: 'withdrawtime', title: '提现时间'},
                {
                    field: 'withdrawstatus', title: '提现状态', templet: function (res) {
                        if (res.withdrawstatus == 1) {
                            return "提现成功";
                        } else {
                            return "提现失败";
                        }
                    }
                },
                {field: 'failreason', title: '失败原因'},
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
            var withdrawstatus = $("#withdrawstatus").val();
            dataTable.reload({
                where: {name: name,withdrawstatus:withdrawstatus},
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
