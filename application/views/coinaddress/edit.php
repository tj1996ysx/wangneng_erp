<?php $this->load->view('layout/public'); ?>
    <main class="lyear-layout-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body" style="height: 100%">
                        <span class="form-horizontal layui-form" id="refund" action="#" method="post"
                              enctype="multipart/form-data" onsubmit="return false;">
                            <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">用户</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="user_name" name="user_name"
                                           lay-verify="required" value="<?=$username?>" autocomplete="off" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">充值虚拟币代码</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="coincode" name="coincode"
                                           lay-verify="required" value="<?=$coincode?>" autocomplete="off" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">充值虚拟币地址</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="coinaddress" name="coinaddress"
                                           lay-verify="required|url" value="<?=$coinaddress?>" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <button class="layui-btn hidden" id="coinaddress_edit" lay-submit
                                            lay-filter="coinaddress_edit">提交</button>
                                </div>
                            </div>
                        </span>
                        </div>
                    </div>
    </main>
    <script>
        //配置插件目录
        layui.config({
            base: '/static/extend/mods/'
            , version: '1.0'
        });

        layui.use(['layer', 'form'], function () {
            var $ = layui.jquery,
                form = layui.form;
            form.on('submit(coinaddress_edit)', function (data) {
                var param = data.field;
                param.user = <?=$userid?>;
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url("coinaddress/edit") . '/' . $adsid; ?>',
                    dataType: "json",
                    async: false,
                    data: param,
                    success: function (data) {
                        var index = parent.layer.getFrameIndex(window.name);
                        if (data.code == 0) {
                            layer.msg(data.msg, {icon: 1, time: 3000}, function () {
                                parent.layer.close(index);
                            });
                        } else {
                            layer.msg(data.msg, {icon: 5, time: 3000}, function () {
                                parent.layer.close(index);
                            });
                        }
                    }
                });
            })
            return false;
        })


    </script>
<?php $this->load->view('layout/footer'); ?>