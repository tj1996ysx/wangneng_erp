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
                    <div class="card-header"><h4>用户列表</h4></div>
                    <div class="card-body">

                        <form class="form-inline" action="/products/index" method="post" onsubmit="return false;">
                            <div class="form-group">
                                <label class="" for="example-if-email">用户姓名</label>
                                <input class="form-control" type="text" name="username" id="username">
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
<script>
    layui.use(['table', 'upload'], function () {
        var table = layui.table;
        var $ = layui.jquery, upload = layui.upload;
        var dataTable = table.render({
            elem: '#test',
            url: '<?php echo base_url("user/index"); ?>',
            // height: 750,
            // cellMinWidth: 150,
            size: 'sm'
            , cols: [[
                {field: 'userid', title: '用户ID'},
                {field: 'username', title: '登录名'},
                {field: 'realname', title: '真实姓名'},
                {field: 'telephone', title: '联系电话'},
                {field: 'country', title: '国家'},
                {field: 'email', title: '邮箱'},
                {field: 'device', title: '登录设备'},
                {field: 'osname', title: '操作系统'},
                {field: 'ipaddress', title: 'ip地址'},
                {field: 'hardware', title: '硬件编码'},
                {field: 'idcountry', title: '证件国家'},
                {field: 'idno', title: '证件号'},
                {field: 'idaddress', title: '证件地址'},
                {field: 'amountspare', title: '可用余额'},
                {
                    field: 'isverified', title: '实名认证', templet: function (res) {
                        if(res.isverified == 1){
                            return "已认证";
                        }else {
                            return "未认证";
                        }
                    }
                },
                {field: 'comratio', title: '佣金比例'},
                {field: 'userlevel', title: '用户等级'},
                {field: 'addtime', title: '添加时间'},
                // {
                //     fixed: 'right', title: '操作', style: 'height:150px;', templet: function (res) {
                //         return '';
                //     }
                // },
            ]]
            , page: true
        });

        $("#searchBtn").click(function () {
            var username = $("#username").val()
            dataTable.reload({
                where: {username: username},
                page: {curr: 1}
            })
        })

        $("#searchClear").click(function () {
            $("#username").val("");
            dataTable.reload({
                where: {},
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
