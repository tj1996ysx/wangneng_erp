<?php $this->load->view('layout/public'); ?>
<main class="lyear-layout-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-body">
                        <span class="form-horizontal layui-form" id="refund" action="#" method="post"
                              enctype="multipart/form-data" onsubmit="return false;">
                            <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">电话号码</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="coincode" name="coincode" lay-verify="required" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">启用状态</label>
                                <div class="col-xs-12">
                                    <select name="coinstatus" id="coinstatus" lay-verify="required" lay-reqText="请选择启用状态" autocomplete="off">
                                        <option value="">设置状态</option>
                                        <option value="1">正常</option>
                                        <option value="0">未启用</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">推荐状态</label>
                                <div class="col-xs-12">
                                    <select name="recommand" id="recommand" lay-verify="required" lay-reqText="请选择推荐状态" autocomplete="off">
                                        <option value="">设置状态</option>
                                        <option value="1">推荐</option>
                                        <option value="0">不推荐</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <button class="layui-btn hidden" id="coin_add" lay-submit lay-filter="coin_add">提交</button>
                                </div>
                            </div>
                        </span>
                        </div>
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
            form.on('submit(coin_add)', function(data){
            $.ajax({
                type: "POST",
                url: '<?php echo base_url("coin/add"); ?>',
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
                        layer.msg(data.msg, {icon: 5,time: 3000},function (){
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