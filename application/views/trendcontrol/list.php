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
                    <div class="card-header"><h4>趋势列表</h4></div>
                    <div class="card-body">
                        <form class="form-inline" action="" method="post" onsubmit="return false;">
                            <div class="layui-inline">
                                <label class="" for="example-if-email">虚拟币代码</label>
                                <input class="form-control" type="text" name="coincode" id="coincode" value="" autocomplete="off">
                            </div>
                            <div class="layui-inline" id="test-range">
                                <label class="" for="example-if-email">日期范围</label>
                                <div class="layui-input-inline">
                                    <input type="text" id="startDate" class="layui-input" placeholder="起始时间" autocomplete="off">
                                </div>
                                <div class="layui-input-inline">-</div>
                                <div class="layui-input-inline">
                                    <input type="text" id="endDate" class="layui-input" placeholder="结束时间" autocomplete="off">
                                </div>
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
    layui.use(['table', 'upload', 'laydate'], function () {
        var table = layui.table;
        var $ = layui.jquery, upload = layui.upload;
        var laydate = layui.laydate;
        var nowTime = new Date().valueOf();
        var max = null;

        var start = laydate.render({
            elem: '#startDate',
            type: 'date',
            max: nowTime,
            btns: ['clear', 'confirm'],
            done: function (value, date) {
                endMax = end.config.max;
                end.config.min = date;
                end.config.min.month = date.month - 1;
            }
        });
        var end = laydate.render({
            elem: '#endDate',
            type: 'date',
            max: nowTime,
            done: function (value, date) {
                if ($.trim(value) == '') {
                    var curDate = new Date();
                    date = {'date': curDate.getDate(), 'month': curDate.getMonth() + 1, 'year': curDate.getFullYear()};
                }
                start.config.max = date;
                start.config.max.month = date.month - 1;
            }
        });
        var dataTable = table.render({
            elem: '#test',
            toolbar: '#barDemo',
            url: '<?php echo base_url("trendcontrol/index"); ?>',
            // height: 750,
            // cellMinWidth: 150,
            size: 'sm'
            , cols: [[
                {field: 'controlid', title: 'ID'},
                {field: 'coincode', title: '虚拟币代码'},
                {field: 'starttime', title: '起始时间'},
                {field: 'endtime', title: '结束时间'},
                {
                    field: 'rangeratio', title: '波动幅度', templet: function (res) {
                        if(res.rangeratio >= 0){
                            return '<button type="button" class="layui-btn">'+ res.rangeratio + '%</button>';
                        }else {
                            return '<button class="layui-btn layui-btn-danger">'+ res.rangeratio + '%</button>';
                        }
                    }
                },
                {field: 'addtime', title: '添加时间'},
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
            var coincode = $("#coincode").val();
            var startDate = $("#startDate").val();
            var endDate = $("#endDate").val();
            dataTable.reload({
                where: {coincode: coincode, startDate: startDate, endDate: endDate},
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
