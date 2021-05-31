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
                    <div class="card-header"><h4>用户登录日志</h4></div>
                    <div class="card-body">
                        <form class="form-inline" action="" method="post" onsubmit="return false;">
                            <div class="form-group">
                                <label class="" for="example-if-email">登陆时间</label>
                                <input class="form-control" type="text" name="search" id="search" value="" autocomplete="off">
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
    <?php if (checkrole("domain", "add")) { ?>
        <a class="layui-btn" lay-event="add">新增</a>
    <?php } ?>
    <!--  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a> -->
</script>
<script>
    layui.use(['table', 'upload','laydate'], function () {
        var table = layui.table;
        var $ = layui.jquery, upload = layui.upload;
        var laydate = layui.laydate;
        //执行一个laydate实例
        laydate.render({
            elem: '#search' //指定元素
        });
        var dataTable = table.render({
            elem: '#test',
            toolbar: '#barDemo',
            url: '<?php echo base_url("loginlog/index"); ?>',
            // height: 750,
            // cellMinWidth: 150,
            size: 'sm'
            , cols: [[
                {field: 'loginid', title: 'ID'},
                {field: 'username', title: '登录用户'},
                {field: 'device', title: '登录设备'},
                {field: 'osname', title: '操作系统'},
                {field: 'hardware', title: '硬件编码'},
                {field: 'addtime', title: '登陆时间'},
                {field: 'ipaddress', title: '登陆ip地址'},
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
            var search = $("#search").val();
            dataTable.reload({
                where: {search: search},
                page: {curr: 1}
            })
        })

        table.on('toolbar(test)', function (obj) {
        });

        //监听行工具事件
        table.on('tool(test)', function (obj) {
            var data = obj.data;
        });
    });
</script>

<?php $this->load->view('layout/footer'); ?>
