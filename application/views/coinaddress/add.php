<?php $this->load->view('layout/public'); ?>
    <main class="lyear-layout-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body" style="height: 100%">
                        <span class="form-horizontal layui-form" id="refund" action="#" method="post"
                              enctype="multipart/form-data" onsubmit="return false;">
<!--                             <div class="form-group">-->
<!--                                <label class="col-xs-12" for="example-email-input">用户</label>-->
<!--                                <div class="col-xs-12">-->
<!--                                    <input class="form-control" type="text" id="user" name="user"-->
<!--                                           lay-verify="required" value="" autocomplete="off" placeholder="请输入用户ID">-->
<!--                                </div>-->
<!--                            </div>-->
                            <div class="form-group">
                                <label class="col-xs-12" for="example-select">充值虚拟币代码</label>
                                <div class="col-xs-12">
                                    <select class="form-control" id="coincode" name="coincode" size="1" lay-search="">
                                        <option value="">--请选择充值虚拟币代码--</option>
                                        <?php foreach ($coincode as $key => $val) { ?>
                                                <option value="<?= $val['coincode'] ?>"><?= $val['coincode'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">充值虚拟币地址</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="coinaddress" name="coinaddress"
                                           lay-verify="required|url" value="" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <button class="layui-btn hidden" id="coinaddress_add" lay-submit
                                            lay-filter="coinaddress_add">提交</button>
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

            form.on('submit(coinaddress_add)', function (data) {
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url("coinaddress/add"); ?>',
                    dataType: "json",
                    async: false,
                    data: data.field,
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