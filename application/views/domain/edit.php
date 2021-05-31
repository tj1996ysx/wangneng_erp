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
                                <label class="col-xs-12" for="example-email-input">域名链接</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="domainname" name="domainname" lay-verify="required" value="<?=$domainname?>"  autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">服务器端口号</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="serverport" name="serverport" lay-verify="required" value="<?=$serverport?>"  autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="example-email-input">启用状态</label>
                                <div class="col-xs-12">
                                    <select name="domainstatus" id="domainstatus" lay-verify="required" lay-reqText="请选择启用状态" autocomplete="off">
                                        <option value="1">启用</option>
                                        <option value="2">暂停</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <button class="layui-btn hidden" id="domain_edit" lay-submit lay-filter="domain_edit">提交</button>
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
            var domainstatus = 'dd[lay-value=' + <?=$domainstatus?> + ']';
            $('#domainstatus').siblings("div.layui-form-select").find('dl').find(domainstatus).click();
            form.on('submit(domain_edit)', function(data){
            $.ajax({
                type: "POST",
                url: '<?php echo base_url("domain/edit").'/'.$domainid; ?>',
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